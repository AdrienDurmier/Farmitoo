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
        $reduction = 0;
        foreach ($promotions as $promotion){
            // D'abord on vérifie si cette promotion est applicable
            if(!$this->isApplicable($promotion->isOnGoing(new \DateTime()), $promotion->getMaxUses(), $promotion->getMinAmount(), $order->getSousTotalHT())){
                continue;
            }

            // Mise à jour de la réduction sur cette commande basé sur le minimum d'achat (sous total HT)
            $reduction += $this->calculReduction($order->getSousTotalHT(), $promotion->getMinAmount(), $promotion->getReduction());

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
     * Vérifie si la promotion est applicable
     * @param bool $isOnGoing
     * @param int|null $maxUses
     * @param int|null $minAmount
     * @param int|null $sousTotalHT
     * @return bool
     */
    public function isApplicable(bool $isOnGoing, ?int $maxUses, ?int $minAmount, ?int $sousTotalHT): bool
    {
        // Si la promotion n'est pas en cours
        if(!$isOnGoing){
            return false;
        }

        // Si tous les usages ont déjà été appliqués
        if($maxUses !== null && $maxUses > 0){
            return true;
        }

        // Si le montant est atteint
        if($minAmount < $sousTotalHT){
            return true;
        }

        return false;
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