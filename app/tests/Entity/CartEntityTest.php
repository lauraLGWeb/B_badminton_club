<?php

namespace App\Tests\Entity;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\CartItem;
use PHPUnit\Framework\TestCase;

class CartEntityTest extends TestCase
{
    /**
     * TEST 1 : get the cart
     */
 
    public function testCartInitialization(): void
    {
        $cart = new Cart();

        $this->assertNull($cart->getId());
        $this->assertFalse($cart->isPaid());
        $this->assertNull($cart->getPurchaseDate());
        $this->assertCount(0, $cart->getCartItem());
        $this->assertFalse($cart->isGiven());
    }

    /**
     * TEST 2 : is the cart paid ?
     */
    
    public function testIsPaid(): void
    {
        $cart = new Cart();
        $cart->setIsPaid(true);

        $this->assertTrue($cart->isPaid());
    }

    /**
     * TEST 3 : set up the purschase date
     */
    
    public function testPurchaseDate(): void
    {
        $cart = new Cart();
        $date = new \DateTimeImmutable();

        $cart->setPurchaseDate($date);

        $this->assertSame($date, $cart->getPurchaseDate());
    }

    /**
     * TEST 4 : create a cart to a user 
     */
    
    public function testUserRelation(): void
    {
        $cart = new Cart();
        $user = new User();

        $cart->setUser($user);

        $this->assertSame($user, $cart->getUser());
    }

    /**
     * TEST 5 : add an item to the cart
     */
    
    public function testAddCartItem(): void
    {
        $cart = new Cart();
        $cartItem = new CartItem();

        $cart->addCartItem($cartItem);

        $this->assertCount(1, $cart->getCartItem());
        $this->assertSame($cart, $cartItem->getCart());
    }

    /**
     * TEST 6 : delete an item to the cart 
     */
     
    public function testRemoveCartItem(): void
    {
        $cart = new Cart();
        $cartItem = new CartItem();

        $cart->addCartItem($cartItem);
        $cart->removeCartItem($cartItem);

        $this->assertCount(0, $cart->getCartItem());
        $this->assertNull($cartItem->getCart());
    }
    /**
     * TEST 7 : is the cart order given ?
     */
    
    public function testIsGiven(): void
    {
        $cart = new Cart();
        $cart->setIsGiven(true);

        $this->assertTrue($cart->isGiven());
    }
}