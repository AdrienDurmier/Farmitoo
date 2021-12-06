<?php

namespace App\Tests\Unit\Entity;

use App\Service\PromotionService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PromotionServiceTest extends KernelTestCase
{
    public function testIsApplicableWithIsOnGoingParameter():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);
        $isOnGoing = false;
        $maxUses = null;
        $minAmount = null;
        $sousTotalHT = null;
        $isNotApplicable = $promotionService->isApplicable(false, $maxUses, $minAmount, $sousTotalHT);
        $this->assertFalse($isNotApplicable);
    }

    public function testIsApplicableWithMaxUsesParameter():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);
        $isOnGoing = true;
        $maxUses = 3;
        $minAmount = null;
        $sousTotalHT = null;
        $isApplicable = $promotionService->isApplicable($isOnGoing, $maxUses, $minAmount, $sousTotalHT);
        $this->assertTrue($isApplicable);
        $isNotApplicable = $promotionService->isApplicable($isOnGoing, 0, $minAmount, $sousTotalHT);
        $this->assertFalse($isNotApplicable);
    }

    public function testIsApplicableWithMinAmountParameter():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);
        $isOnGoing = true;
        $maxUses = null;
        $minAmount = 500;
        $sousTotalHT = 1000;
        $isApplicable = $promotionService->isApplicable($isOnGoing, $maxUses, $minAmount, $sousTotalHT);
        $this->assertTrue($isApplicable);
        $isNotApplicable = $promotionService->isApplicable($isOnGoing, $maxUses, 2000, $sousTotalHT);
        $this->assertFalse($isNotApplicable);
    }


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

    public function testCalculReductionMinItemsWhenOrderMinItemsIsSuperiorToPromotionMinItems():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $orderMinItems = 15;
        $promotionMinItems = 10;
        $promotionReduction = 1000;

        $reduction = $promotionService->calculReductionMinItems($orderMinItems, $promotionMinItems, $promotionReduction);
        $this->assertEquals(1000, $reduction);
    }

    public function testCalculReductionMinItemsWhenOrderMinItemsIsInferiorToPromotionMinItems():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $orderMinItems = 5;
        $promotionMinItems = 10;
        $promotionReduction = 1000;

        $reduction = $promotionService->calculReductionMinItems($orderMinItems, $promotionMinItems, $promotionReduction);
        $this->assertEquals(0, $reduction);
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

    public function testUpdateMaxUsesIfReduction():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $reduction = 100;
        $freeDelivery = false;
        $maxUses = 3;

        $maxUses = $promotionService->updateMaxUses($reduction, $freeDelivery, $maxUses);
        $this->assertEquals(2, $maxUses);
    }

    public function testUpdateMaxUsesIfFreeDelivery():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $reduction = 0;
        $freeDelivery = true;
        $maxUses = 5;

        $maxUses = $promotionService->updateMaxUses($reduction, $freeDelivery, $maxUses);
        $this->assertEquals(4, $maxUses);
    }

    public function testUpdateMaxUsesIfMaxUseIsNull():void
    {
        $kernel = self::bootKernel();
        $promotionService = $kernel->getContainer()->get(PromotionService::class);

        $reduction = 0;
        $freeDelivery = true;
        $maxUses = null;

        $maxUses = $promotionService->updateMaxUses($reduction, $freeDelivery, $maxUses);
        $this->assertNull($maxUses);
    }
}
