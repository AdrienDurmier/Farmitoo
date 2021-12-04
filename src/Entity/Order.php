<?php


namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    const STEP_CART = 0;
    const STEP_ADDRESS = 1;
    const STEP_SHIPMENT = 2;
    const STEP_VALIDATION = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("item:read")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="order")
     */
    private $items;

    /**
     * @ORM\Column(type="integer")
     * @Groups("item:read")
     */
    private $step;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->step = self::STEP_CART;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setOrder($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrder() === $this) {
                $item->setOrder(null);
            }
        }

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(int $step): self
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Compte le nombre total d'article dans la commande
     * @Groups("item:read")
     * @return int|null
     */
    public function getCountItems(): ?int
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->getQuantity();
        }
        return $total;
    }

    /**
     * @Groups("item:read")
     * @return int|null
     */
    public function getSousTotalHT(): ?int
    {
        $total = 0;
        foreach ($this->getItems() as $item){
            $total += $item->getTotalHT();
        }
        return $total;
    }

    /**
     * @Groups("item:read")
     * @return int|null
     */
    public function getTotalShipment(): ?int
    {
        $total = 0.00;
        foreach ($this->getItems() as $item){
            $total += $item->getTotalShipment();
        }
        return $total;
    }

    /**
     * @Groups("item:read")
     * @return int|null
     */
    public function getTotalHT(): ?int
    {
        return $this->getSousTotalHT() + $this->getTotalShipment();
    }

    /**
     * @Groups("item:read")
     * @return int|null
     */
    public function getTotalTax(): ?int
    {
        $total = 0;
        foreach ($this->getItems() as $item){
            $total +=
                  $item->getQuantity()
                * $item->getProduct()->getPrice()
                * $item->getProduct()->getBrand()->getTax()->getRate() / 100;
        }

        $total += ($this->getTotalShipment() * 20.00) / 100; // Ajout de la TVA à 20% sur les frais de port

        return $total;
    }

    /**
     * @Groups("item:read")
     * @return int|null
     */
    public function getTotalTTC(): ?int
    {
        return $this->getTotalHT() + $this->getTotalTax();
    }
}
