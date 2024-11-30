<?php

namespace App\Entity;

use App\Repository\InboundsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InboundsRepository::class)]
class Inbounds
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'inbounds')]
    private ?Inventorie $inventories = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): static
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getInventories(): ?Inventorie
    {
        return $this->inventories;
    }

    public function setInventories(?Inventorie $inventories): static
    {
        $this->inventories = $inventories;

        return $this;
    }
}
