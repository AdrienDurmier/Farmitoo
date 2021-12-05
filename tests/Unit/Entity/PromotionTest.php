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

    public function testIsOnGoingWhenDateBetweenStartAndEnd():void
    {
        $promotion = new Promotion();
        $date = \DateTime::createFromFormat('Y-m-d', '2021-12-15');
        $dateStart = \DateTime::createFromFormat('Y-m-d', '2021-12-01');
        $promotion->setDateStart($dateStart);
        $dateEnd = \DateTime::createFromFormat('Y-m-d', '2021-12-31');
        $promotion->setDateEnd($dateEnd);

        $isOnGoing = $promotion->isOnGoing($date);
        self::assertTrue($isOnGoing);
    }

    public function testIsOnGoingWhenDateOutStartAndEnd():void
    {
        $promotion = new Promotion();
        $date = \DateTime::createFromFormat('Y-m-d', '2021-10-02');
        $dateStart = \DateTime::createFromFormat('Y-m-d', '2021-12-01');
        $promotion->setDateStart($dateStart);
        $dateEnd = \DateTime::createFromFormat('Y-m-d', '2021-12-31');
        $promotion->setDateEnd($dateEnd);

        $isOnGoing = $promotion->isOnGoing($date);
        self::assertFalse($isOnGoing);
    }

    public function testIsOnGoingWhenDateStartIsNull():void
    {
        $promotion = new Promotion();
        $date = \DateTime::createFromFormat('Y-m-d', '2021-02-25');
        $dateEnd = \DateTime::createFromFormat('Y-m-d', '2021-12-01');
        $promotion->setDateEnd($dateEnd);
        $isOnGoing = $promotion->isOnGoing($date);
        self::assertTrue($isOnGoing);

        $date = \DateTime::createFromFormat('Y-m-d', '2022-02-25');
        $dateEnd = \DateTime::createFromFormat('Y-m-d', '2021-12-01');
        $promotion->setDateEnd($dateEnd);
        $isOnGoing = $promotion->isOnGoing($date);
        self::assertFalse($isOnGoing);
    }

    public function testIsOnGoingWhenDateEndIsNull():void
    {
        $promotion = new Promotion();
        $date = \DateTime::createFromFormat('Y-m-d', '2022-02-25');
        $dateStart = \DateTime::createFromFormat('Y-m-d', '2021-12-01');
        $promotion->setDateStart($dateStart);
        $isOnGoing = $promotion->isOnGoing($date);
        self::assertTrue($isOnGoing);

        $date = \DateTime::createFromFormat('Y-m-d', '2021-02-25');
        $dateStart = \DateTime::createFromFormat('Y-m-d', '2021-12-01');
        $promotion->setDateStart($dateStart);
        $isOnGoing = $promotion->isOnGoing($date);
        self::assertFalse($isOnGoing);
    }

}
