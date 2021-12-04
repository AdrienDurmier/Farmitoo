<?php


namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("item:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("item:read")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     * @Groups("item:read")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="items")
     * @Groups("item:read")
     */
    private $order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @Groups("item:read")
     * @return int|null
     */
    public function getTotalHT(): ?int
    {
        return $this->quantity * $this->product->getPrice();
    }

    /**
     * @Groups("item:read")
     * @return int|null
     */
    public function getTotalShipment(): ?int
    {
        $total = 0.00;
        switch ($this->product->getBrand()->getTitle()) {
            case 'Farmitoo':
                $total = ceil($this->getQuantity() / 3) * 20 ;
                break;
            case 'Gallagher':
                $total = 15;
                break;
        }
        return $total;
    }
}
