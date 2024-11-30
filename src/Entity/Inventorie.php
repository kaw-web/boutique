<?php

namespace App\Entity;

use App\Repository\InventorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventorieRepository::class)]
class Inventorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'inventories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $Reference = null;

    #[ORM\Column]
    private ?float $quantity = null;

    /**
     * @var Collection<int, Channel>
     */
    #[ORM\ManyToMany(targetEntity: Channel::class, inversedBy: 'inventories')]
    private Collection $channels;

    /**
     * @var Collection<int, Inbounds>
     */
    #[ORM\OneToMany(targetEntity: Inbounds::class, mappedBy: 'inventories')]
    private Collection $inbounds;

    public function __construct()
    {
        $this->channels = new ArrayCollection();
        $this->inbounds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?Product
    {
        return $this->Reference;
    }

    public function setReference(?Product $Reference): static
    {
        $this->Reference = $Reference;

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

    /**
     * @return Collection<int, Channel>
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(Channel $channel): static
    {
        if (!$this->channels->contains($channel)) {
            $this->channels->add($channel);
        }

        return $this;
    }

    public function removeChannel(Channel $channel): static
    {
        $this->channels->removeElement($channel);

        return $this;
    }

    /**
     * @return Collection<int, Inbounds>
     */
    public function getInbounds(): Collection
    {
        return $this->inbounds;
    }

    public function addInbound(Inbounds $inbound): static
    {
        if (!$this->inbounds->contains($inbound)) {
            $this->inbounds->add($inbound);
            $inbound->setInventories($this);
        }

        return $this;
    }

    public function removeInbound(Inbounds $inbound): static
    {
        if ($this->inbounds->removeElement($inbound)) {
            // set the owning side to null (unless already changed)
            if ($inbound->getInventories() === $this) {
                $inbound->setInventories(null);
            }
        }

        return $this;
    }
}
