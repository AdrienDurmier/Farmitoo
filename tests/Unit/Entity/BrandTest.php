<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Brand;
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
    }
}
