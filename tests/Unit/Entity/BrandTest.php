<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Vat;
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

    public function testGetVat():void
    {
        $tax = new Vat();
        $brand = $this->brand->setVat($tax);
        self::assertInstanceOf(Brand::class, $brand);
        self::assertEquals($tax, $this->brand->getVat());
    }
}
