<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\CartItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\BrowserKit\Request;


use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Account;


final class CartController extends AbstractController
{
   #[Route('/boutique/panier', name: 'app_cart')]
    public function cart(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $carts = $em->getRepository(Cart::class)->findBy(['user' => $user]);


        $actualCart = null;
        foreach ($carts as $cart){
            if(!$cart->isPaid()){
                $actualCart = $cart;
                break;
            }
        }

        return $this->render('shop/cart.html.twig',
         ['cart' => $actualCart ]);
    }

//adding to the cart 

 #[Route('/boutique/panier/ajouter{id}', name: 'app_addItem')]
    public function addItem(EntityManagerInterface $em, Product $product, ): Response
    {
        $user = $this->getUser();
        if(!$user){
             dd('pas connecté');
        }

        $carts = $em->getRepository(Cart::class)->findBy(['user' => $user]);

        $actualCart = null;
        foreach ($carts as $cart){
            if(!$cart->isPaid()){
                $actualCart = $cart;
                break;
            }
        }

        // if the membre has no cart yet, it will create one
        if(!$actualCart){
            $actualCart = new Cart();
            $actualCart-> setIsPaid(false);
            $actualCart-> setUser($user);
            $actualCart ->setPurchaseDate(new \DateTimeImmutable());
            $em->persist($actualCart);
        }

            // checking if the item is already in the cart
            $itemExisting = $em->getRepository(CartItem::class)->findOneBy([
            'cart' => $actualCart,
            'product' => $product

           

        ]);;
            // in this case add One to the existant
            if($itemExisting){
              $itemExisting->setQuantity($itemExisting->getQuantity()+1);
              
              $em->flush();
                
            // adding the item in the cart if not alerady existing 
            } else {
                $newItem = new CartItem();
                $newItem->setCart($actualCart);
                $newItem->setProduct($product);
                $newItem->setQuantity(1);
                $em->persist($newItem);
                $this->addFlash('success', 'Produit ajouté au panier !');
        
                $em->flush();

            }


        return $this->redirectToRoute('app_shop');
    }




//delete the Item
    #[Route('/boutique/panier/{id}', name: 'app_deleteItem')]
   public function deleteItem(EntityManagerInterface $em, $id) : Response
    {

        $repo = $em->getRepository(CartItem::class);
        $item = $repo->find($id);

        if (!$item) {
        $this->addFlash('error', 'Produit introuvable');
        return $this->redirectToRoute('app_cart');
        }
        
        $em->remove($item);
        $em->flush();
        
        return $this->redirectToRoute('app_cart');
    }





    //going to stripe API 
#[Route('/boutique/panier/paiement', name: 'app_payment')]
public function Payment(EntityManagerInterface $em) : Response
{
    $user = $this->getUser();
    
    $cart = $em->getRepository(Cart::class)->findOneBy([
        'user' => $user,
        'isPaid' => false
    ]);

    if (!$cart || $cart->getCartItem()->isEmpty()) {
        $this->addFlash('error', 'Votre panier est vide');
        return $this->redirectToRoute('app_shop');
    }

    Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

    $lineItems = [];
    foreach ($cart->getCartItem() as $item) {
        $lineItems[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $item->getProduct()->getTitle(),
                ],
                'unit_amount' => $item->getProduct()->getPrice() * 100,
            ],
            'quantity' => $item->getQuantity(),
        ];
    }

    $checkoutSession = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => $this->generateUrl('app_shop', [], UrlGeneratorInterface::ABSOLUTE_URL),
        'cancel_url' => $this->generateUrl('app_cart', [], UrlGeneratorInterface::ABSOLUTE_URL),
    ]);

    return $this->redirect($checkoutSession->url);
}

//test one
#[Route('/boutique/panier/paiement/stripe', name: 'app_test_stripe')]
public function testStripe(): Response
{
     \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    
    try {
        \Stripe\Account::retrieve();
        $message = "✅ API Stripe connectée avec succès !";
        $color = "#10b981";
    } catch (\Exception $e) {
        $message = "❌ Erreur : " . $e->getMessage();
        $color = "#ef4444";
    }
    
    return new Response("
        <div style='text-align:center; margin-top:100px; font-family:Arial;'>
            <h1 style='font-size:5em; color:{$color};'>$message</h1>
        </div>
    ");
}

}