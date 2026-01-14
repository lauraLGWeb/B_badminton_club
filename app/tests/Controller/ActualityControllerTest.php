<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Document\Actualities;

class ActualityControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient([
            'environment' => 'test',
            'debug' => true,
        ]);
    }

    
    /**
     * TEST 1 : create actuality only by admin 
     */
    public function testCreateActualityPageIsAccessibleForAdmin(): void
    {
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        //get an admin user
        $admin = $userRepository->findOneBy(['email' => 'nnicolas@example.net']);

        if (!$admin) {
            $this->markTestSkipped('Aucun admin trouvé');
        }
        // connect the admin 
        $this->client->loginUser($admin);

        // try to go to the create actuality page
        $this->client->request('GET', '/Actualites/création');
        
        $this->assertResponseIsSuccessful();
    }

    /**
     * TEST 2 : create an actuality
     */
    public function testCreateActuality(): void
    {
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $admin = $userRepository->findOneBy(['email' => 'nnicolas@example.net']);

        if (!$admin) {
            $this->markTestSkipped('Aucun admin trouvé');
        }
          // connect the admin 
        $this->client->loginUser($admin);

        //fill up the form 
        $crawler = $this->client->request('GET', '/Actualites/création');
        $form = $crawler->selectButton('Enregistrer')->form([
            'actuality[title]' => 'Test Actualité PHPUnit',
            'actuality[description]' => 'Ceci est une actualité de test créée par PHPUnit',
            'actuality[picture]' => 'https://example.com/test.jpg',
            'actuality[eventOn]' => '2026-02-15',
        ]);

        $this->client->submit($form);

        // ckeck if we come back to actualities pages 
        $this->assertResponseRedirects('/Actualites');
    }

    /**
     * TEST 3 : delete an actuality
     */
    public function testDeleteActuality(): void
    {
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $admin = $userRepository->findOneBy(['email' => 'nnicolas@example.net']);

        if (!$admin) {
            $this->markTestSkipped('Aucun admin trouvé');
        }

        $this->client->loginUser($admin);

        // get the actuality from mongobd
        $dm = static::getContainer()->get('doctrine_mongodb.odm.document_manager');
        $actuality = $dm->getRepository(Actualities::class)->findOneBy([]);

        if (!$actuality) {
            $this->markTestSkipped('Aucune actualité MongoDB trouvée');
        }

        // delete the actuality 
        $this->client->request('GET', '/Actualites/suppression/' . $actuality->getId());

        // check if getting back to actuality page 
        $this->assertResponseRedirects('/Actualites');
    }
}