<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Document\Actualities;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

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
     * TEST 1 : create actuality page only accessible by admin 
     */
    public function testCreateActualityPageIsAccessibleForAdmin(): void
    {
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        //get an admin user
        $admin = $userRepository->findOneBy(['email' => 'qbernard@example.org']);

        if (!$admin) {
            $this->assertNotNull('Aucun admin trouvé');
        }
        // connect the admin 
        $this->client->loginUser($admin);

        // try to go to the create actuality page
        $this->client->request('GET', '/admin/Actualites/création');
        
        $this->assertResponseIsSuccessful();
    }


    /**
     * TEST 2 : create an actuality
     */
    public function testCreateActuality(): void
    {
    
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $admin = $userRepository->findOneBy([
    'email' => 'qbernard@example.org'
]);

          // connect the admin 
        $this->client->loginUser($admin);

        $this->assertNotNull($admin);


        //fill up the form 
        $crawler = $this->client->request('GET', '/admin/Actualites/création');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Publier l\'événement')->form([
            'actuality[title]' => 'Test Actualité PHPUnit',
            'actuality[description]' => 'Ceci est une actualité de test créée par PHPUnit',
            'actuality[picture]' => 'https://example.com/test.jpg',
            'actuality[eventOn]' => '2027-02-15',
        ]);

        $this->client->submit($form);

        // ckeck if we come back to actualities pages 
        $this->assertResponseRedirects('/Actualites');
    }

















    /**
     * TEST 3 : delete an actuality
     */
//     public function testDeleteActuality(): void
//     {

//           $client = static::createClient();

//     // 🔹 Démarre explicitement la session
//     $session = static::getContainer()->get('session');
//     $session->start();

//     $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
//     $admin = $userRepository->findOneBy(['email' => 'auguste32@example.org']);

//     $this->assertNotNull($admin);

//     $client->loginUser($admin);

//     $dm = static::getContainer()->get('doctrine_mongodb.odm.document_manager');
//     $actuality = $dm->getRepository(Actualities::class)->findOneBy([]);

//     $this->assertNotNull($actuality);

//     // 🔹 Génère le token APRES le start()
//     $csrfToken = static::getContainer()
//         ->get('security.csrf.token_manager')
//         ->getToken('delete_actuality_' . $actuality->getId())
//         ->getValue();

//     $client->request('POST',
//         '/admin/Actualites/suppression/' . $actuality->getId(),
//         ['_token' => $csrfToken]
//     );
// dump($client->getResponse()->getStatusCode());
// dump($client->getResponse()->getContent());

//     $this->assertResponseRedirects('/Actualites');
// }
}  






