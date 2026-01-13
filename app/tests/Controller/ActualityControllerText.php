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
     * TEST 1 : create actuality only for admin 
     */
    public function testCreateActualityPageIsAccessibleForAdmin(): void
    {
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        //get an admin user
        $admin = $userRepository->findOneBy(['email' => 'nnicolas@example.net']);

        if (!$admin) {
            $this->markTestSkipped('Aucun admin trouvé');
        }
        // connect the user 
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
        $admin = $userRepository->findOneBy(['email' => 'marine98@example.org']);

        if (!$admin) {
            $this->markTestSkipped('Aucun admin trouvé');
        }

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

        // Vérifie la redirection après création
        $this->assertResponseRedirects('/Actualites');
    }

    /**
     * TEST 6 : Supprimer une actualité
     */
    public function testDeleteActuality(): void
    {
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $admin = $userRepository->findOneBy(['email' => 'marine98@example.org']);

        if (!$admin) {
            $this->markTestSkipped('Aucun admin trouvé');
        }

        $this->client->loginUser($admin);

        // Récupère une actualité de test (MongoDB)
        $dm = static::getContainer()->get('doctrine_mongodb.odm.document_manager');
        $actuality = $dm->getRepository(Actualities::class)->findOneBy([]);

        if (!$actuality) {
            $this->markTestSkipped('Aucune actualité MongoDB trouvée');
        }

        // Supprime l'actualité
        $this->client->request('GET', '/Actualites/suppression/' . $actuality->getId());

        // Vérifie la redirection
        $this->assertResponseRedirects('/Actualites');
    }
}