<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Promotion;
use PHPUnit\Framework\TestCase;

class PromotionTest extends TestCase
{
    private $promotion;

    protected function setUp():void
    {
        parent::setUp();
        $this->promotion = new Promotion();
    }

    public function testGetMinAmount():void
    {
        $value = 50000;
        $promotion = $this->promotion->setMinAmount($value);
        self::assertInstanceOf(Promotion::class, $promotion);
        self::assertEquals($value, $this->promotion->getMinAmount());
    }

    public function testGetReduction():void
    {
        $value = 8;
        $promotion = $this->promotion->setReduction($value);
        self::assertInstanceOf(Promotion::class, $promotion);
        self::assertEquals($value, $this->promotion->getReduction());
    }

    public function testGetFreeDelivery():void
    {
        $value = false;
        $promotion = $this->promotion->setFreeDelivery($value);
        self::assertInstanceOf(Promotion::class, $promotion);
        self::assertEquals($value, $this->promotion->getFreeDelivery());
    }
}
