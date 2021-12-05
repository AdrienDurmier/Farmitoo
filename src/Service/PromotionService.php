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
            // Si la promotion est en cours où si le nombre d'usages max est atteint
            if(!$promotion->isOnGoing(new \DateTime()) || $promotion->getMaxUses()){
                continue;
            }
            // Mise à jour de la réduction sur cette commande basé sur le minimum d'achat (sous total HT)
            $reduction = $this->calculReduction($order->getSousTotalHT(), $promotion->getMinAmount(), $promotion->getReduction());

            // Mise à jour de la réduction sur cette commande basé sur le minimum d'objet
            $reduction += $this->calculReductionMinItems($order->getCountItems(), $promotion->getMinItems(), $promotion->getReduction());

            $order->setReduction($reduction);

            // Mise à jour des frais de port de cette commande en fonction de la promotion
            $freeDelivery = $this->isFreeDelivery($order->getFreeDelivery(), $promotion->getFreeDelivery());
            $order->setFreeDelivery($freeDelivery);

            // Mise à jour du nombre d'usages restant
            $maxUses = $this->updateMaxUses($reduction, $freeDelivery, $promotion->getMaxUses());
            $promotion->setMaxUses($maxUses);
            $this->em->persist($promotion);
        }
        $this->em->persist($order);
        $this->em->flush();
        return $order;
    }

    /**
     * Calcul de la réduction basé sur le total du panier
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
     * Calcul de la réduction basé sur le nombre d'articles commandés
     * @param int $orderNbItems
     * @param int|null $promotionMinItems
     * @param int|null $promotionReduction
     * @return float|int
     */
    public function calculReductionMinItems(int $orderNbItems, ?int $promotionMinItems, ?int $promotionReduction): int
    {
        if ($promotionMinItems == null){
            return 0;
        }
        return ($orderNbItems >= $promotionMinItems) ? $promotionReduction : 0;
    }

    /**
     * Calcul si les frais de port d'une commande sont applicables en fonction d'une promotion
     * @return float|int
     */
    public function isFreeDelivery(bool $orderFreeDelivery, bool $promotionFreeDelivery): bool
    {
        return ($orderFreeDelivery) ? true : $promotionFreeDelivery;
    }

    /**
     * Mise à jour du nombre d'usage restant
     * @return float|int
     */
    public function updateMaxUses(int $reduction, bool $promotionFreeDelivery, ?int $promotionMaxUses): ?int
    {
        if($promotionMaxUses > 0){
            if($reduction > 0 || $promotionFreeDelivery) {
                return $promotionMaxUses - 1;
            }
        }
        return null;
    }
}