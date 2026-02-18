<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\CartItem;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

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
        $user = $userRepository->findOneBy(['email' => 'qbernard@example.org']);

    
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
//     public function testAddProductToCart(): void
// {
//     $client = static::createClient();
//     $container = static::getContainer();

//     // login user
//     $userRepository = $container->get('doctrine')->getRepository(User::class);
//     $user = $userRepository->findOneBy(['email' => 'auguste32@example.org']);
//     $this->assertNotNull($user);

//     $client->loginUser($user);

//     // récupérer un produit
//     $productRepository = $container->get('doctrine')->getRepository(Product::class);
//     $product = $productRepository->findOneBy([]);
//     $this->assertNotNull($product, 'Product not found');

//     // 🔥 Charger la page produit (celle qui contient le formulaire)
//     $crawler = $client->request('GET', '/shop'); 
//     $this->assertResponseIsSuccessful();
//     // ou la page détail produit si ton form est dessus

//     // 🔥 Trouver le bon formulaire
//     $form = $crawler->filter('form[action="/membre/boutique/panier/ajouter/'.$product->getId().'"]')
//         ->form([
//             'size' => 'M',
//             'gender' => 'Homme',
//         ]);

//     // 🔥 Soumettre le formulaire (le token est déjà dedans)
//     $client->submit($form);

//     $this->assertResponseRedirects('/shop');
//     $client->followRedirect();

//     $this->assertSelectorTextContains('.flash-success', 'Produit ajouté au panier !');

//     // Vérifier en base
//     $em = $container->get('doctrine')->getManager();
//     $em->clear(); // Nettoyer le cache Doctrine

//     $cartItemRepository = $em->getRepository(CartItem::class);
//     $cartItem = $cartItemRepository->findOneBy(['product' => $product]);

//     $this->assertNotNull($cartItem, 'Le produit n’a pas été ajouté au panier');
    
// }



    /**
     * TEST 4 : delete an item from the cart
     */
    // public function testRemoveProductFromCart(CsrfTokenManager $csrfTokenManager): void
    // {
    //     // Connexion
    //     $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
    //     $user = $userRepository->findOneBy(['email' => 'auguste32@example.org']);

    //     $this->client->loginUser($user);

    //     // get an item 
    //     $productRepository = static::getContainer()->get('doctrine')->getRepository(Product::class);
    //     $product = $productRepository->findOneBy([]);

       
    //     $this->assertNotNull($product, 'Aucun produit dans les fixtures');
        

    //     // add the item into the cart 
    //     $this->client->request('GET', '/membre/boutique/panier/ajouter/'. $product->getId());
        
    //     // Récupère le CartItem créé
    //     $em = static::getContainer()->get('doctrine')->getManager();
    //     $cartItemRepository = $em->getRepository(CartItem::class);
    //     $cartItem = $cartItemRepository->findOneBy(['product' => $product]);

    //     $token = $csrfTokenManager->getToken('delete_item' . $cartItem->getId())->getValue();

        
    //      $this->assertNotNull($cartItem, 'Le produit n\'a pas été ajouté au panier');
    

    //     // delete the item
    //     $this->client->request('GET', '/membre/boutique/panier/supprimer/' . $cartItem->getId(),
    //     [
    //         '_token' => $token
    //     ]);



    //      // checking the item is deleted

    //     $em->clear();

    //     $deletedCartItem = $cartItemRepository->find($cartItem->getId());

    //     $this->assertNull($deletedCartItem);

    //     // check the redirection
    //     $this->assertResponseRedirects('/membre/boutique/panier');
    // }
}
