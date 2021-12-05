<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use DateTime;
use DateTimeInterface;
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minItems;

    /**
     * @ORM\Column(type="integer")
     */
    private $reduction;

    /**
     * @ORM\Column(type="boolean")
     */
    private $freeDelivery;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxUses;

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

    public function getMinItems(): ?int
    {
        return $this->minItems;
    }

    public function setMinItems(?int $minItems): self
    {
        $this->minItems = $minItems;

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

    public function getDateStart(): ?DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(?DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Vérifie si la promotion est en cours
     * @param DateTime $date
     * @return bool
     */
    public function isOnGoing(DateTime $date): bool
    {
        if($this->getDateStart() == null && $this->getDateEnd() > $date){
            return true;
        }
        if($this->getDateEnd() == null && $this->getDateStart() < $date){
            return true;
        }
        if($this->getDateStart() < $date && $this->getDateEnd() > $date){
            return true;
        }
        return false;
    }

    public function getMaxUses(): ?int
    {
        return $this->maxUses;
    }

    public function setMaxUses(?int $maxUses): self
    {
        $this->maxUses = $maxUses;

        return $this;
    }
}
