<?php

namespace App\Controller;

use App\Entity\Cart;
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

            //get the user
            $user = $this->getUser();

            //get the cart with the user, just the cart unpaid yet
            $cart = $em->getRepository(Cart::class)->findOneBy([
                'user'=>$user,
                'isPaid'=> false
            ]);

            if (!$cart || $cart->getCartItem()->isEmpty()) {
                $this->addFlash('error', 'Votre panier est vide');
                return $this->redirectToRoute('app_shop');
}

            
        // stripe configuration
           Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        // Prépare les items
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
            
            // Crée la session Stripe
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => $this->generateUrl('app_shop', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('app_cart', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);
            
            // Redirige direct vers Stripe
            return $this->redirect($checkoutSession->url);
    }

}