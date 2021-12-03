<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Tax;
use PHPUnit\Framework\TestCase;

class TaxTest extends TestCase
{
    private $tax;

    protected function setUp():void
    {
        parent::setUp();
        $this->tax = new Tax();
    }

    public function testGetTitle():void
    {
        $value = '20%';
        $tax = $this->tax->setTitle($value);
        self::assertInstanceOf(Tax::class, $tax);
        self::assertEquals($value, $this->tax->getTitle());
        self::assertEquals($value, $this->tax); // test du __toString
    }

    public function testGetRate():void
    {
        $value = 20.00;
        $tax = $this->tax->setRate($value);
        self::assertInstanceOf(Tax::class, $tax);
        self::assertEquals($value, $this->tax->getRate());
    }
}
