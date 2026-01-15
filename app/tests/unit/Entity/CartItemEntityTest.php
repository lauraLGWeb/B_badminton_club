<?php

namespace App\Tests\Unit\Entity;

use App\Entity\CartItem;
use App\Entity\Cart;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CartItemEntityTest extends TestCase
{
    // get the cartitem selected 
    public function testCartItemInitialization(): void
    {
        $cartItem = new CartItem();

        $this->assertNull($cartItem->getId());
        $this->assertNull($cartItem->getCart());
        $this->assertNull($cartItem->getProduct());
        $this->assertNull($cartItem->getQuantity());
        $this->assertNull($cartItem->getSize());
        $this->assertNull($cartItem->getGender());
    }

    //attribute the item to the user cart
    public function testCartRelation(): void
    {
        $cart = new Cart();
        $cartItem = new CartItem();

        $cartItem->setCart($cart);

        $this->assertSame($cart, $cartItem->getCart());
    }


    // get the item selected into the cart as the cartitem
    public function testProductRelation(): void
    {
        $product = new Product();
        $cartItem = new CartItem();

        $cartItem->setProduct($product);

        $this->assertSame($product, $cartItem->getProduct());
    }


    // testing the quantity of items 
    public function testQuantity(): void
    {
        $cartItem = new CartItem();

        $cartItem->setQuantity(3);

        $this->assertSame(3, $cartItem->getQuantity());
    }


    //  setting size if item has size
    public function testNullableSize(): void
    {
        $cartItem = new CartItem();

        $cartItem->setSize(null);
        $this->assertNull($cartItem->getSize());

        $cartItem->setSize('M');
        $this->assertSame('M', $cartItem->getSize());
    }


       //  setting gender if item has gender
    public function testNullableGender(): void
    {
        $cartItem = new CartItem();

        $cartItem->setGender(null);
        $this->assertNull($cartItem->getGender());

        $cartItem->setGender('Homme');
        $this->assertSame('Homme', $cartItem->getGender());
    }
}
