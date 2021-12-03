<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Tax;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    private $brand;

    protected function setUp():void
    {
        parent::setUp();
        $this->brand = new Brand();
    }

    public function testGetTitle():void
    {
        $value = 'Farmitoo';
        $brand = $this->brand->setTitle($value);
        self::assertInstanceOf(Brand::class, $brand);
        self::assertEquals($value, $this->brand->getTitle());
        self::assertEquals($value, $this->brand); // test du __toString
    }

    public function testGetTax():void
    {
        $tax = new Tax();
        $brand = $this->brand->setTax($tax);
        self::assertInstanceOf(Brand::class, $brand);
        self::assertEquals($tax, $this->brand->getTax());
    }
}
