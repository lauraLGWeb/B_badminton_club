<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\CartItem;

class CartControllerTest extends WebTestCase
{
    private $client;

    // Cette méthode s'exécute AVANT chaque test
    protected function setUp(): void
    {
        // Crée un client de test (navigateur virtuel)
        $this->client = static::createClient();
    }

    /**
     * TEST 1 : Page panier accessible pour utilisateur connecté
     * 
     * On teste : GET /boutique/panier
     * Résultat attendu : Code 200 + titre "Panier" visible
     */
    public function testCartPageIsAccessibleWhenLoggedIn(): void
    {
        // ÉTAPE 1 : Récupérer un utilisateur de test depuis les fixtures
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'membre@exemple.com']); // Adapte l'email

        // Vérifie qu'on a bien un user
        $this->assertNotNull($user, 'Aucun utilisateur trouvé avec cet email dans les fixtures');

        // ÉTAPE 2 : Simuler la connexion
        $this->client->loginUser($user);

        // ÉTAPE 3 : Accéder à la page panier
        $this->client->request('GET', '/boutique/panier');

        // ÉTAPE 4 : Vérifier que la page charge bien (HTTP 200)
        $this->assertResponseIsSuccessful();

        // ÉTAPE 5 : Vérifier qu'on voit bien un titre (adapte selon ton template)
        $this->assertSelectorTextContains('h1', 'Panier');
    }

    /**
     * TEST 2 : Ajouter un produit au panier
     * 
     * On teste : GET /boutique/panier/ajouter{id}
     * Résultat attendu : Produit ajouté en BDD + redirection + message flash
     */
    public function testAddProductToCart(): void
    {
        // ÉTAPE 1 : Connexion utilisateur
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'membre@exemple.com']);

        $this->assertNotNull($user, 'Utilisateur introuvable');
        $this->client->loginUser($user);

        // ÉTAPE 2 : Récupérer un produit de test
        $productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $product = $productRepository->findOneBy([]); // Premier produit trouvé

        $this->assertNotNull($product, 'Aucun produit trouvé dans les fixtures');

        // ÉTAPE 3 : Ajouter le produit au panier
        $this->client->request('GET', '/boutique/panier/ajouter' . $product->getId());

        // ÉTAPE 4 : Vérifier la redirection vers la boutique
        $this->assertResponseRedirects('/boutique');

        // ÉTAPE 5 : Suivre la redirection pour vérifier le message flash
        $this->client->followRedirect();

        // ÉTAPE 6 : Vérifier le message de succès (adapte la classe CSS)
        $this->assertSelectorExists('.alert-success');
    }

    /**
     * TEST 3 : Supprimer un produit du panier
     * 
     * On teste : GET /boutique/panier/{id}
     * Résultat attendu : CartItem supprimé de la BDD
     */
    public function testRemoveProductFromCart(): void
    {
        // ÉTAPE 1 : Connexion
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'membre@exemple.com']);
        $this->client->loginUser($user);

        // ÉTAPE 2 : Ajouter d'abord un produit
        $productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $product = $productRepository->findOneBy([]);

        $this->client->request('GET', '/boutique/panier/ajouter' . $product->getId());
        $this->client->followRedirect();

        // ÉTAPE 3 : Récupérer le CartItem qui vient d'être créé
        $em = static::getContainer()->get('doctrine')->getManager();
        $cartItemRepository = $em->getRepository(CartItem::class);
        $cartItem = $cartItemRepository->findOneBy(['product' => $product]);

        $this->assertNotNull($cartItem, 'Le produit n\'a pas été ajouté au panier');

        // ÉTAPE 4 : Supprimer le CartItem
        $cartItemId = $cartItem->getId();
        $this->client->request('GET', '/boutique/panier/' . $cartItemId);

        // ÉTAPE 5 : Vérifier la redirection vers le panier
        $this->assertResponseRedirects('/boutique/panier');

        // ÉTAPE 6 : Vérifier que le CartItem a bien été supprimé
        $em->clear(); // Rafraîchit Doctrine
        $deletedItem = $cartItemRepository->find($cartItemId);
        $this->assertNull($deletedItem, 'Le produit n\'a pas été supprimé du panier');
    }

    /**
     * TEST 4 : Sécurité - Page panier redirige si non connecté
     * 
     * On teste : GET /boutique/panier SANS connexion
     * Résultat attendu : Redirection vers /login
     */
    public function testCartPageRedirectsIfNotLoggedIn(): void
    {
        // ÉTAPE 1 : Accéder au panier SANS connexion
        $this->client->request('GET', '/boutique/panier');

        // ÉTAPE 2 : Vérifier la redirection vers login
        $this->assertResponseRedirects('/login');
    }
}