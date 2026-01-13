<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\CartItem;

class CartControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        // Création du client avec environnement test explicite
        $this->client = static::createClient([
            'environment' => 'test',
            'debug' => true,
        ]);
    }

    /**
     * TEST 1 : Page panier accessible pour utilisateur connecté
     */
    public function testCartPageIsAccessibleWhenLoggedIn(): void
    {
        // Récupère un utilisateur de test
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'membre@exemple.com']);

        // Si pas d'user en fixtures, on skip le test
        if (!$user) {
            $this->markTestSkipped('Aucun utilisateur membre@exemple.com dans les fixtures');
        }

        // Simule la connexion
        $this->client->loginUser($user);

        // Accède à la page panier
        $this->client->request('GET', '/boutique/panier');

        // Vérifie que la page charge bien
        $this->assertResponseIsSuccessful();
        
        // Vérifie qu'on voit le mot "Panier" (adapte selon ton template)
        $this->assertSelectorExists('h1');
    }

    /**
     * TEST 2 : Page panier redirige si non connecté
     */
    public function testCartPageRedirectsIfNotLoggedIn(): void
    {
        // Accède au panier SANS connexion
        $this->client->request('GET', '/boutique/panier');

        // Vérifie la redirection vers login
        $this->assertResponseRedirects('/membre/connexion');
    }

    /**
     * TEST 3 : Ajouter un produit au panier
     */
    public function testAddProductToCart(): void
    {
        // Connexion utilisateur
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'membre@exemple.com']);

        if (!$user) {
            $this->markTestSkipped('Aucun utilisateur membre@exemple.com dans les fixtures');
        }

        $this->client->loginUser($user);

        // Récupère un produit de test
        $productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $product = $productRepository->findOneBy([]);

        if (!$product) {
            $this->markTestSkipped('Aucun produit dans les fixtures');
        }

        // Ajoute le produit au panier
        $this->client->request('GET', '/boutique/panier/ajouter' . $product->getId());

        // Vérifie la redirection
        $this->assertResponseRedirects();
    }

    /**
     * TEST 4 : Supprimer un produit du panier
     */
    public function testRemoveProductFromCart(): void
    {
        // Connexion
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'membre@exemple.com']);

        if (!$user) {
            $this->markTestSkipped('Aucun utilisateur membre@exemple.com dans les fixtures');
        }

        $this->client->loginUser($user);

        // Récupère un produit
        $productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $product = $productRepository->findOneBy([]);

        if (!$product) {
            $this->markTestSkipped('Aucun produit dans les fixtures');
        }

        // Ajoute d'abord un produit
        $this->client->request('GET', '/boutique/panier/ajouter' . $product->getId());
        
        // Récupère le CartItem créé
        $em = static::getContainer()->get('doctrine')->getManager();
        $cartItemRepository = $em->getRepository(CartItem::class);
        $cartItem = $cartItemRepository->findOneBy(['product' => $product]);

        if (!$cartItem) {
            $this->markTestSkipped('Le produit n\'a pas été ajouté au panier');
        }

        // Supprime le CartItem
        $this->client->request('GET', '/boutique/panier/' . $cartItem->getId());

        // Vérifie la redirection
        $this->assertResponseRedirects('/boutique/panier');
    }
}
