<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Promotion;
use Doctrine\ORM\EntityManagerInterface;

class PromotionService
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Order $order
     * @return Order
     */
    public function apply(Order $order): Order
    {
        $promotions = $this->em->getRepository(Promotion::class)->findAll();
        foreach ($promotions as $promotion){
            $reduction = $this->calculReduction($order->getSousTotalHT(), $promotion->getMinAmount(), $promotion->getReduction());
            $order->setReduction($reduction);

            $freeDelivery = $this->isFreeDelivery($order->getFreeDelivery(), $promotion->getFreeDelivery());
            $order->setFreeDelivery($freeDelivery);
        }
        $this->em->persist($order);
        $this->em->flush();
        return $order;
    }

    /**
     * Calcul de la réduction applicable sur une commande à partir d'une promotion
     * @param int $orderSousTotalHT
     * @param int $promotionMinAmount
     * @param int $promotionReduction
     * @return float|int
     */
    public function calculReduction(int $orderSousTotalHT, int $promotionMinAmount, int $promotionReduction): int
    {
        $reduction = 0;
        if($promotionMinAmount <= $orderSousTotalHT){
            $reduction = intval($orderSousTotalHT / $promotionMinAmount) * $promotionReduction;
        }
        return $reduction;
    }

    /**
     * Calcul si les frais de port d'une commande sont applicables en fonction d'une promotion
     * @return float|int
     */
    public function isFreeDelivery(bool $orderFreeDelivery, bool $promotionFreeDelivery): bool
    {
        return ($orderFreeDelivery) ? true : $promotionFreeDelivery;
    }
}