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

        return $this->render('shop/cart.html.twig',
         ['cart' => $actualCart ]);
    }

//adding to the cart 

 #[Route('/boutique/panier/ajouter{id}', name: 'app_addItem')]
    public function addItem(EntityManagerInterface $em, Product $product): Response
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

            // checking if the item is already in the cart
            $itemExisting = $em->getRepository(CartItem::class)->findOneBy([
            'cart' => $actualCart,
            'product' => $product
        ]);;

            // in this case add One to the existant
            if($itemExisting){
                $itemExisting->setQuantity($itemExisting->getQuantity()+1);
                
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


        return $this->redirectToRoute('app_cart');
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




