<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * GET OR CREATE THE CART
     */
    public function getOrCreateActiveCart(User $user): Cart
    {
        // is a cart unpaid ? 
        $carts = $this->em->getRepository(Cart::class)->findBy(['user' => $user]);

        foreach ($carts as $cart) {
            if (!$cart->isPaid()) {
                return $cart;
            }
        }

        // if not cart, we create one 
        $newCart = new Cart();
        $newCart->setIsPaid(false);
        $newCart->setUser($user);
        $newCart->setPurchaseDate(new \DateTimeImmutable());
        
        $this->em->persist($newCart);
        $this->em->flush();

        return $newCart;
    }

    /**
     * add an item to the cart
     */
    public function addProduct(Cart $cart, Product $product, ?string $size, ?string $gender): void
    {
        // is there already the same item in the cart 
        $existingItem = $this->em->getRepository(CartItem::class)->findOneBy([
            'cart' => $cart,
            'product' => $product,
            'size' => $size,
            'gender' => $gender
        ]);

        if ($existingItem) {
            // incremente the number
            $existingItem->setQuantity($existingItem->getQuantity() + 1);
        } else {
            // Create the new item
            $newItem = new CartItem();
            $newItem->setCart($cart);
            $newItem->setProduct($product);
            $newItem->setQuantity(1);
            $newItem->setSize($size);
            $newItem->setGender($gender);
            
            $this->em->persist($newItem);
        }

        $this->em->flush();
    }

    /**
     * delete an item
     */
    public function removeItem(CartItem $item): void
    {
        $this->em->remove($item);
        $this->em->flush();
    }

    /**
     * get the cart as paid
     */
    public function markAsPaid(Cart $cart): void
    {
        $cart->setIsPaid(true);
        $cart->setPurchaseDate(new \DateTimeImmutable());
        $this->em->flush();
    }

 
}