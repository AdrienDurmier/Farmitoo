<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    private $item;

    protected function setUp():void
    {
        parent::setUp();
        $this->item = new Item();
    }

    public function testGetProduct():void
    {
        $product = new Product();
        $item = $this->item->setProduct($product);
        self::assertInstanceOf(Item::class, $item);
        self::assertEquals($product, $this->item->getProduct());
    }

    public function testGetQuantity():void
    {
        $value = 77;
        $item = $this->item->setQuantity($value);
        self::assertInstanceOf(Item::class, $item);
        self::assertEquals($value, $this->item->getQuantity());
    }

    public function testGetOrder():void
    {
        $order = new Order();
        $item = $this->item->setOrder($order);
        self::assertInstanceOf(Item::class, $item);
        self::assertEquals($order, $this->item->getOrder());
    }

    public function testGetTotalHT():void
    {
        $product = new Product();
        $product->setTitle('Produit test');
        $product->setPrice(200);
        $item = $this->item->setProduct($product);
        $item->setQuantity(5);
        self::assertInstanceOf(Item::class, $item);
        self::assertEquals(1000, $this->item->getTotalHT());
    }

    public function testGetTotalShipmentWhenBrandIsFarmitoo():void
    {
        $farmitoo = new Brand();
        $farmitoo->setTitle('Farmitoo');

        $product1 = new Product();
        $product1->setTitle('Produit test');
        $product1->setPrice(200);
        $product1->setBrand($farmitoo);

        $item = $this->item->setProduct($product1);
        $item->setQuantity(1);

        self::assertInstanceOf(Item::class, $item);
        self::assertEquals(20, $this->item->getTotalShipment());

        $item = $this->item->setProduct($product1);
        $item->setQuantity(4);
        self::assertEquals(40, $this->item->getTotalShipment());

        $item = $this->item->setProduct($product1);
        $item->setQuantity(7);
        self::assertEquals(60, $this->item->getTotalShipment());
    }

    public function testGetTotalShipmentWhenBrandIsGallagher():void
    {
        $gallagher = new Brand();
        $gallagher->setTitle('Gallagher');

        $product1 = new Product();
        $product1->setTitle('Produit test');
        $product1->setPrice(200);
        $product1->setBrand($gallagher);

        $item = $this->item->setProduct($product1);
        $item->setQuantity(1);

        self::assertInstanceOf(Item::class, $item);
        self::assertEquals(15, $this->item->getTotalShipment());

        $item = $this->item->setProduct($product1);
        $item->setQuantity(4);
        self::assertEquals(15, $this->item->getTotalShipment());

        $item = $this->item->setProduct($product1);
        $item->setQuantity(7);
        self::assertEquals(15, $this->item->getTotalShipment());
    }
}
