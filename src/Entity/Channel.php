<?php

namespace App\Entity;

use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChannelRepository::class)]
class Channel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    /**
     * @var Collection<int, Pricing>
     */
    #[ORM\OneToMany(targetEntity: Pricing::class, mappedBy: 'channel')]
    private Collection $pricings;

    /**
     * @var Collection<int, Inventorie>
     */
    #[ORM\ManyToMany(targetEntity: Inventorie::class, mappedBy: 'channels')]
    private Collection $inventories;

    public function __construct()
    {
        $this->pricings = new ArrayCollection();
        $this->inventories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Pricing>
     */
    public function getPricings(): Collection
    {
        return $this->pricings;
    }

    public function addPricing(Pricing $pricing): static
    {
        if (!$this->pricings->contains($pricing)) {
            $this->pricings->add($pricing);
            $pricing->setChannel($this);
        }

        return $this;
    }

    public function removePricing(Pricing $pricing): static
    {
        if ($this->pricings->removeElement($pricing)) {
            // set the owning side to null (unless already changed)
            if ($pricing->getChannel() === $this) {
                $pricing->setChannel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Inventorie>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventorie $inventory): static
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories->add($inventory);
            $inventory->addChannel($this);
        }

        return $this;
    }

    public function removeInventory(Inventorie $inventory): static
    {
        if ($this->inventories->removeElement($inventory)) {
            $inventory->removeChannel($this);
        }

        return $this;
    }
}
