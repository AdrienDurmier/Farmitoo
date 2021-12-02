<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Brand;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $product;

    protected function setUp():void
    {
        parent::setUp();
        $this->product = new Product();
    }

    public function testGetTitle():void
    {
        $value = 'Cuve à gasoil';
        $product = $this->product->setTitle($value);
        self::assertInstanceOf(Product::class, $product);
        self::assertEquals($value, $this->product->getTitle());
    }

    public function testGetPrice():void
    {
        $value = 250000;
        $product = $this->product->setPrice($value);
        self::assertInstanceOf(Product::class, $product);
        self::assertEquals($value, $this->product->getPrice());
    }

    public function testGetBrand():void
    {
        $brand = new Brand();
        $product = $this->product->setBrand($brand);
        self::assertInstanceOf(Product::class, $product);
        self::assertEquals($brand, $this->product->getBrand());
    }
}
