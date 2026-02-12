<?php
// app/tests/Controller/HomeControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class HomeControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    // ========================================
    // ROUTES for everyone
    // ========================================

    public function testHomePageIsSuccessful(): void
    {
        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue au Blois Badminton Club');
    }

    public function testPricesPageIsSuccessful(): void
    {
        $this->client->request('GET', '/Tarifs');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Tarifs');
    }

    public function testPartnersPageIsSuccessful(): void
    {
        $this->client->request('GET', '/Partenaires');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'partenaires');
    }

    public function testInscriptionPageIsSuccessful(): void
    {
        $this->client->request('GET', '/Inscription');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'S\'inscrire saison 2025-2026');
    }

    public function testSchedulesPageIsSuccessful(): void
    {
        $this->client->request('GET', '/Creneaux');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Créneaux d\'entraînement');
    }

    public function testTryPageIsSuccessful(): void
    {
        $this->client->request('GET', '/Essais');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Comment faire un essai');
    }

    public function testCoachesPageIsSuccessful(): void
    {
        $this->client->request('GET', '/Leclub/Entraineurs');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nos Entraîneurs Professionnels');
    }

    public function testCaMembersPageIsSuccessful(): void
    {
        $this->client->request('GET', '/Leclub/Membres');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'L\'équipe du Blois Badminton Club');
    }

    public function testRulesPageIsSuccessful(): void
    {
        $this->client->request('GET', '/Leclub/Reglement');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Règlement et Charte');
    }

    public function testLegalMentionsPageIsSuccessful(): void
    {
        $this->client->request('GET', '/mentions');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mentions légales et CGV');
    }

    public function testAccountPageRedirectsWhenNotLoggedIn(): void
    {
        $this->client->request('GET', '/membre/Leclub/Membres/compte');
        $this->assertResponseRedirects('/connexion');
    }

    public function testAdminDashboardRedirectsWhenNotLoggedIn(): void
    {
        $this->client->request('GET', '/admin');
        $this->assertResponseRedirects('/connexion');
    }

    public function testItemsListRedirectsWhenNotLoggedIn(): void
    {
        $this->client->request('GET', '/admin/Liste-boutique');
        $this->assertResponseRedirects('/connexion');
    }

    public function testMembersListRedirectsWhenNotLoggedIn(): void
    {
        $this->client->request('GET', '/admin/membres/liste');
        $this->assertResponseRedirects('/connexion');
    }


    // ========================================
    // member cannot have dashboard
    // ========================================


    public function testMembreCannotAccessAdminDashboard(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $membre = $userRepository->findOneBy(['email' => 'suzanne.sauvage@example.com']);

        $this->client->loginUser($membre);
        $this->client->request('GET', '/admin');
        
        $this->assertResponseStatusCodeSame(403);
    }

    // ========================================
    // for admin only 
    // ========================================

    public function testAdminCanAccessDashboard(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy(['email' => 'bernard.noel@example.org']);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin');
        
        $this->assertResponseIsSuccessful();
    }

    public function testAdminCanAccessItemsList(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy(['email' => 'bernard.noel@example.org']);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/Liste-boutique');
        
        $this->assertResponseIsSuccessful();
    }

    public function testAdminCanAccessMembersList(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy(['email' => 'bernard.noel@example.org']);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/membres/liste');
        
        $this->assertResponseIsSuccessful();
    }

    public function testAdminCanAccessAddItemsPage(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy(['email' => 'bernard.noel@example.org']);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/Liste-boutique/ajouter');
        
        $this->assertResponseIsSuccessful();
    }
}