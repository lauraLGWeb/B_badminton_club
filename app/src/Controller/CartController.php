<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;


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

        // if the membre has no cart yet, it will create one
        if(!$actualCart){
            $actualCart = new Cart();
            $actualCart-> setIsPaid(false);
            $actualCart-> setUser($user);
            $actualCart ->setPurchaseDate(new \DateTimeImmutable());
            $em->persist($actualCart);
        }

        return $this->render('shop/cart.html.twig', ["cart" => $actualCart]);
    }


//delete the Item
    #[Route('/boutique/panier/{id}', name: 'app_deleteItem')]
   public function deleteItem(EntityManagerInterface $em, $id) : Response
    {

        $repo = $em->getRepository(CartItem::class);
        $item = $repo->find($id);

        $em->remove($item);
        $em->flush();
        
        return $this->redirectToRoute('app_cart');
    }

}

//  $cartItem = new CartItem;
//         $cartItem-> setCart($actualCart);
//         $cartItem-> setProduct($product);
//         $cartItem-> setQuantity(1);
//         $em->persist($cartItem);
//         $em-> flush();




