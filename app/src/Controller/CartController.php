<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Service\CartService;
use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MEMBRE')]
final class CartController extends AbstractController
{
    // get the cart
    #[Route('/membre/boutique/panier', name: 'app_cart')]
    public function cart(CartService $cartService): Response
    {
        $user = $this->getUser();
        $cart = $cartService->getOrCreateActiveCart($user);

        return $this->render('shop/cart.html.twig', ['cart' => $cart]);
    }

    // add an item
    #[Route('/membre/boutique/panier/ajouter/{id}', name: 'app_addItem')]
    public function addItem(Product $product, Request $request, CartService $cartService): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            dd('pas connecté');
        }

        // get size and gender from the form
        $size = $request->request->get('size') ?: $request->query->get('size');
        $gender = $request->request->get('gender') ?: $request->query->get('gender');

        // get or create the cart
        $cart = $cartService->getOrCreateActiveCart($user);

        // add to the cart 
        $cartService->addProduct($cart, $product, $size, $gender);

        $this->addFlash('success', 'Produit ajouté au panier !');
        
        return $this->redirectToRoute('app_shop');
    }

    // goes to  Stripe
    #[Route('/membre/boutique/panier/paiement', name: 'app_payment')]
    public function Payment(CartService $cartService, StripeService $stripeService, EntityManagerInterface $em): Response
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

        try {
            // create strip session
            $paymentSession = $stripeService->createCheckoutSession($cart);
            
            // goes to stripe

            return $this->redirect($paymentSession->url);
            
            
        } catch (\Exception $e) {
            $this->addFlash('error', '❌ Erreur Stripe : ' . $e->getMessage());
            return $this->redirectToRoute('app_cart');
        }
    }

    // delete an item
    #[Route('/membre/boutique/panier/supprimer/{id}', name: 'app_deleteItem')]
    public function deleteItem(EntityManagerInterface $em, $id, CartService $cartService): Response
    {
        $repo = $em->getRepository(CartItem::class);
        $item = $repo->find($id);

        if (!$item) {
            $this->addFlash('error', 'Produit introuvable');
            return $this->redirectToRoute('app_cart');
        }
        
        $cartService->removeItem($item);
        
        $this->addFlash('success', 'Produit retiré du panier');
        
        return $this->redirectToRoute('app_cart');
    }

    // Payment ok
    #[Route('/membre/boutique/paiement_accepté', name: 'app_payment_success')]
    public function paymentSuccess(Request $request, CartService $cartService, StripeService $stripeService, EntityManagerInterface $em): Response
    {
        // get the id stripe session
        $sessionId = $request->query->get('session_id');
        
        if (!$sessionId) {
            $this->addFlash('error', 'Session invalide');
            return $this->redirectToRoute('app_cart');
        }

        try {
            // get payment status
            $session = $stripeService->verifyPaymentSession($sessionId);
            
            // payment ok 
            if ($session->payment_status === 'paid') {
                $cartId = $session->metadata->cart_id;
                $cart = $em->getRepository(Cart::class)->find($cartId);
                
                if ($cart && !$cart->IsPaid()) {
                    // mark the cart as paid
                    $cartService->markAsPaid($cart);
                    
                    $this->addFlash('success', '🎉 Paiement confirmé ! Merci pour votre commande.');
                   
                }
            }
            
        } catch (\Exception $e) {
            // if error with stripe
            $this->addFlash('error', 'Erreur lors de la vérification du paiement');
        }

        return $this->redirectToRoute('app_shop');
    }



    // Payment canceled
    #[Route('/membre/boutique/paiement_refusé', name: 'app_payment_canceled')]
    public function cancelledPayment(): Response
    {
        $this->addFlash('warning', 'Paiement annulé. Votre panier est toujours disponible.');
        
        return $this->redirectToRoute('app_cart');
    }
}