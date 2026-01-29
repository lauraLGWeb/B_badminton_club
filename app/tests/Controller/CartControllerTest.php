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
        // creation of the client in test environement
        $this->client = static::createClient([
            'environment' => 'test',
            'debug' => true,
        ]);
    }

    /**
     * TEST 1 : cart page  accessible for user connected 
     */
    public function testCartPageIsAccessibleWhenLoggedIn(): void
    {
        // take a user test with specific email
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'thierry.breton@example.net']);

    
        // connect the user
        $this->client->loginUser($user);

        // goes to the cart page 
        $this->client->request('GET', '/membre/boutique/panier');

        // wait for the response
        $this->assertResponseIsSuccessful();
        

        $this->assertSelectorExists('h1');
    }

    /**
     * TEST 2 : if no connected, redirection to connexion page 
     */
    public function testCartPageRedirectsIfNotLoggedIn(): void
    {
        // try to go to cart page without connexion
        $this->client->request('GET', '/membre/boutique/panier');

        // wait if redirect to connexion page 
        $this->assertResponseRedirects('/connexion');
    }

    /**
     * TEST 3 : Add the item in the cart 
     */
    public function testAddProductToCart(): void
    {
        // connexion of the user
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'thierry.breton@example.net']);

    

        $this->client->loginUser($user);

        // get an item
        $productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $product = $productRepository->findOneBy(['price' => '40']);

        if (!$product) {
            $this->markTestSkipped('Aucun produit dans les fixtures');
        }

        // Add the item into the cart 
        $this->client->request('GET', '/membre/boutique/panier/ajouter/' . $product->getId());

        // check if redirection
        $this->assertResponseRedirects();
    }

    /**
     * TEST 4 : delete an item from the cart
     */
    public function testRemoveProductFromCart(): void
    {
        // Connexion
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'thierry.breton@example.net']);

        $this->client->loginUser($user);

        // get an item 
        $productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
        $product = $productRepository->findOneBy([]);

        if (!$product) {
            $this->assertNotNull($product, 'Aucun produit dans les fixtures');
        }

        // add the item into the cart 
        $this->client->request('GET', '/membre/boutique/panier/ajouter' . $product->getId());
        
        // Récupère le CartItem créé
        $em = static::getContainer()->get('doctrine')->getManager();
        $cartItemRepository = $em->getRepository(CartItem::class);
        $cartItem = $cartItemRepository->findOneBy(['product' => $product]);

        if (!$cartItem) {
            $this->assertNotNull('Le produit n\'a pas été ajouté au panier');
        }

        // delete the item
        $this->client->request('GET', '/membre/boutique/panier/supprimer/' . $cartItem->getId());

        // check the redirection
        $this->assertResponseRedirects('/membre/boutique/panier');
    }
}
