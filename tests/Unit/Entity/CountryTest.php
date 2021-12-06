<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    private $country;

    protected function setUp():void
    {
        parent::setUp();
        $this->country = new Country();
    }

    public function testGetTitle():void
    {
        $value = 'France';
        $country = $this->country->setTitle($value);
        self::assertInstanceOf(Country::class, $country);
        self::assertEquals($value, $this->country->getTitle());
        self::assertEquals($value, $this->country); // test du __toString
    }

    public function testGetRate():void
    {
        $value = 'FRA';
        $country = $this->country->setIso3166Alpha3($value);
        self::assertInstanceOf(Country::class, $country);
        self::assertEquals($value, $this->country->getIso3166Alpha3());
    }
}
