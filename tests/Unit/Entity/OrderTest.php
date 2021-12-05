<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Tax;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $order;

    protected function setUp():void
    {
        parent::setUp();
        $this->order = new Order();

        $tax20 = new Tax();
        $tax20->setTitle('20%');
        $tax20->setRate(20.00);

        $tax05 = new Tax();
        $tax05->setTitle('5%');
        $tax05->setRate(5.00);

        $farmitoo = new Brand();
        $farmitoo->setTitle('Farmitoo');
        $farmitoo->setTax($tax20);

        $gallagher = new Brand();
        $gallagher->setTitle('Gallagher');
        $gallagher->setTax($tax05);

        $product1 = new Product();
        $product1->setTitle('Cuve à gasoil');
        $product1->setPrice(25000);
        $product1->setBrand($farmitoo);

        $product2 = new Product();
        $product2->setTitle('Nettoyant pour cuve');
        $product2->setPrice(5000);
        $product2->setBrand($farmitoo);

        $product3 = new Product();
        $product3->setTitle('Piquet de clôture');
        $product3->setPrice(1000);
        $product3->setBrand($gallagher);

        $item1 = new Item();
        $item1->setProduct($product1);
        $item1->setQuantity(1);

        $item2 = new Item();
        $item2->setProduct($product2);
        $item2->setQuantity(3);

        $item3 = new Item();
        $item3->setProduct($product3);
        $item3->setQuantity(5);

        $this->order->addItem($item1);
        $this->order->addItem($item2);
        $this->order->addItem($item3);
    }

    public function testGetItems():void
    {
        self::assertCount(3, $this->order->getItems());
        foreach($this->order->getItems() as $item){
            self::assertTrue($item instanceof Item);
        }
    }

    public function testCountItems():void
    {
        self::assertEquals(9, $this->order->getCountItems());
    }

    public function testGetSousTotalHT():void
    {
        self::assertEquals(45000, $this->order->getSousTotalHT());
    }

    public function testGetTotalShipment():void
    {
        self::assertEquals(55, $this->order->getTotalShipment());
        $this->order->setFreeDelivery(true);
        self::assertEquals(0, $this->order->getTotalShipment());
    }

    public function testGetTotalHT():void
    {
        self::assertEquals(45055, $this->order->getTotalHT());
    }

    public function testGetTotalTax():void
    {
        self::assertEquals(8261, $this->order->getTotalTax());
    }

    public function testGetTotalTTC():void
    {
        self::assertEquals(53316, $this->order->getTotalTTC());
    }
}
