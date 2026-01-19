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
use Symfony\Component\HttpFoundation\Request;


use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Account;

use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MEMBRE')]
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

        if(!$actualCart){
            $actualCart = new Cart();
            $actualCart-> setIsPaid(false);
            $actualCart-> setUser($user);
            $actualCart ->setPurchaseDate(new \DateTimeImmutable());
            $em->persist($actualCart);
        }

        return $this->render('shop/cart.html.twig',
         ['cart' => $actualCart ]);
    }

//adding to the cart 

 #[Route('/boutique/panier/ajouter{id}', name: 'app_addItem')]
    public function addItem(EntityManagerInterface $em, Product $product, Request $request): Response
    {

        $user = $this->getUser();
        if(!$user){
             dd('pas connecté');
        }


        // Récupère size et gender depuis le formulaire
        $size = $request->request->get('size') ?: $request->query->get('size');
        $gender = $request->request->get('gender') ?: $request->query->get('gender');

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

        // Vérifie si l'item existe AVEC la même taille et genre
         $itemExisting = $em->getRepository(CartItem::class)->findOneBy([
            'cart' => $actualCart,
            'product' => $product,
            'size' => $size,
            'gender' => $gender
    ]);

            
            // in this case add One to the existant
            if($itemExisting){
              $itemExisting->setQuantity($itemExisting->getQuantity()+1);
              
              $em->flush();
              $this->addFlash('success', 'Produit ajouté au panier !');
              return $this->redirectToRoute('app_shop');

            // adding the item in the cart if not alerady existing 
            } else {

                $newItem = new CartItem();
                $newItem->setCart($actualCart);
                $newItem->setProduct($product);
                $newItem->setQuantity(1);
                $newItem->setSize($size);      
                $newItem->setGender($gender);  
               
                
                $em->persist($newItem);      
                $em->flush();

                $this->addFlash('success', 'Produit ajouté au panier !');
                return $this->redirectToRoute('app_shop');
            }


        return $this->redirectToRoute('app_shop');
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



    // VRAI PAIEMENT STRIPE
    Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    
    try {
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

        $paymentSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('app_payment_canceled', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'metadata' => [
                'cart_id' => $cart->getId(),
            ],
        ]);


      
        // ✅ Si on arrive ici, Stripe a répondu !
           return $this->redirect($paymentSession->url);
      
        
    } catch (\Exception $e) {
        $this->addFlash('error', '❌ Erreur Stripe : ' . $e->getMessage());
        return $this->redirectToRoute('app_cart');
    }
}






//delete the Item
    #[Route('/boutique/panier/supprimer/{id}', name: 'app_deleteItem')]
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







// payment succed

    #[Route('/boutique/paiement_accepté', name: 'app_payment_success')]
 public function paymentSuccess(Request $request, EntityManagerInterface $em): Response
{
    // 1️⃣ Récupérer l'ID de session envoyé par Stripe
    $sessionId = $request->query->get('session_id');
    
    if (!$sessionId) {
        $this->addFlash('error', 'Session invalide');
        return $this->redirectToRoute('app_cart');
    }

    \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

    try {
        // is the payment done ? 
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        
        /// if cart is paid
        if ($session->payment_status === 'paid') {
            
            
            $cartId = $session->metadata->cart_id;
            $cart = $em->getRepository(Cart::class)->find($cartId);
            
            if ($cart && !$cart->isIsPaid()) {
                // then the cart become paid with the day time
                $cart->setIsPaid(true);
                $cart->setPurchaseDate(new \DateTime());
                      
            
                $em->flush();
             $this->addFlash('success', '🎉 Paiement confirmé ! Merci pour votre commande.');

            }
        }
        
    } catch (\Exception $e) {
        // En cas d'erreur avec Stripe
        $this->addFlash('error', 'Erreur lors de la vérification du paiement');
    }

    return $this->redirectToRoute('app_shop');
}


// payment cancelled

    #[Route('/boutique/paiement_refusé', name: 'app_payment_canceled')]
   public function cancelledPayment() : Response
    {
          $this->addFlash('warning', 'Paiement annulé. Votre panier est toujours disponible.');
        
        return $this->redirectToRoute('app_cart');
    }

}

