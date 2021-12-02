<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $minAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $reduction;

    /**
     * @ORM\Column(type="boolean")
     */
    private $freeDelivery;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinAmount(): ?int
    {
        return $this->minAmount;
    }

    public function setMinAmount(int $minAmount): self
    {
        $this->minAmount = $minAmount;

        return $this;
    }

    public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function setReduction(int $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getFreeDelivery(): ?bool
    {
        return $this->freeDelivery;
    }

    public function setFreeDelivery(bool $freeDelivery): self
    {
        $this->freeDelivery = $freeDelivery;

        return $this;
    }
}
