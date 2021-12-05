<?php

namespace App\Tests\Unit\Entity;

use App\Service\PromotionService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PromotionServiceTest extends KernelTestCase
{
    public function testCalculReductionWithoutPromotion():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $orderSousTotalHT = 40000;
        $promotionMinAmount = 50000;
        $promotionReduction = 1000;

        $reduction = $promotionService->calculReduction($orderSousTotalHT, $promotionMinAmount, $promotionReduction);
        $this->assertEquals(0, $reduction);
    }

    public function testCalculReductionWithPromotion():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $orderSousTotalHT = 60000;
        $promotionMinAmount = 50000;
        $promotionReduction = 1000;

        $reduction = $promotionService->calculReduction($orderSousTotalHT, $promotionMinAmount, $promotionReduction);
        $this->assertEquals(1000, $reduction);
    }

    public function testCalculReductionIfOrderSousTotalIsTwicePromotionMinAmount():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $orderSousTotalHT = 100000;
        $promotionMinAmount = 50000;
        $promotionReduction = 1000;

        $reduction = $promotionService->calculReduction($orderSousTotalHT, $promotionMinAmount, $promotionReduction);
        $this->assertEquals(2000, $reduction);
    }

    public function testIsFreeDeliveryIfOrderFreeDeliveryIsTrue():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $orderFreeDelivery = true;
        $promotionFreeDelivery = false;

        $freeFelivery = $promotionService->isFreeDelivery($orderFreeDelivery, $promotionFreeDelivery);
        $this->assertTrue($freeFelivery);
    }

    public function testIsFreeDeliveryIfPromotionFreeDeliveryIsTrue():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $orderFreeDelivery = false;
        $promotionFreeDelivery = true;

        $freeFelivery = $promotionService->isFreeDelivery($orderFreeDelivery, $promotionFreeDelivery);
        $this->assertTrue($freeFelivery);
    }
}
