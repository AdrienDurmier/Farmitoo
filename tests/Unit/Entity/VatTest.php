<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Vat;
use App\Entity\Country;
use PHPUnit\Framework\TestCase;

class VatTest extends TestCase
{
    private $vat;

    protected function setUp():void
    {
        parent::setUp();
        $this->vat = new Vat();
    }

    public function testGetTitle():void
    {
        $value = '20%';
        $vat = $this->vat->setTitle($value);
        self::assertInstanceOf(Vat::class, $vat);
        self::assertEquals($value, $this->vat->getTitle());
        self::assertEquals($value, $this->vat); // test du __toString
    }

    public function testGetRate():void
    {
        $value = 20.00;
        $vat = $this->vat->setRate($value);
        self::assertInstanceOf(Vat::class, $vat);
        self::assertEquals($value, $this->vat->getRate());
    }

    public function testGetCountry():void
    {
        $country = new Country();
        $vat = $this->vat->setCountry($country);
        self::assertInstanceOf(Vat::class, $vat);
        self::assertEquals($country, $this->vat->getCountry());
    }
}
