<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;


class ProductEntityTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        $this->product = new Product();
    }

    /**
     * TEST 1 : title getter/setter
     */
    public function testTitleProductGetterSetter(): void
    {
        $product = 'Boîte de volants';
        $this->product->setTitle($product);
        
        $this->assertEquals($product, $this->product->getTitle());
    }

     

    /**
     * TEST 2 : description getter/setter
     */
    public function testdescriptionGetterSetter(): void
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $this->product->setDescription($description);
        
        $this->assertEquals($description, $this->product->getDescription());
    }

    /**
     * TEST 3 : price getter/setter
     */
    public function testpriceGetterSetter(): void
    {
        $price = '40';
        $this->product->setPrice($price);
        
        $this->assertEquals($price, $this->product->getPrice());
    }

    /**
     * TEST 4 : picture getter/setter
     */
    public function testpictureGetterSetter(): void
    {
        $picture = "pictures/tshirt.jpg";
        $this->product->setPicture($picture);
        
        $this->assertEquals($picture, $this->product->getPicture());
    }

       /**
     * TEST 5: HasSize is false bu default
     */
    public function testHasSizeDefaultValue(): void
    {
        // new product
        $this->assertFalse($this->product->getHasSize());
    }

    /**
     * TEST 6 : HasSize getter/setter
     */
    public function testHasSizeGetterSetter(): void
    {
        $this->product->setHasSize(true);
        
        $this->assertTrue($this->product->getHasSize());
    }

}