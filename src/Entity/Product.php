<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations:[
       // new Get(),
        new GetCollection(),
        //new Post(),
        new Put(),
        // new Patch(),
        new Delete()
    ]
)]
#[ApiFilter(SearchFilter::class, properties:['name'=> 'exact'])]
#[ApiFilter(DateFilter::class, properties:['createdAt'])]
#[Get(
    normalizationContext:['groups' => ['read']]
)]
#[Post(
    denormalizationContext:['groups' => ['write']],
    normalizationContext:['groups' => ['read']]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    #[Groups(['read', 'write'])]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[NotBlank()]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?bool $dropshipping = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $description = null;

    /**
     * @var Collection<int, Pricing>
     */
    #[ORM\OneToMany(targetEntity: Pricing::class, mappedBy: 'product')]
    private Collection $pricings;

    /**
     * @var Collection<int, Inventorie>
     */
    #[ORM\OneToMany(targetEntity: Inventorie::class, mappedBy: 'Reference')]
    private Collection $inventories;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable:true, type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->pricings = new ArrayCollection();
        $this->inventories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isDropshipping(): ?bool
    {
        return $this->dropshipping;
    }

    public function setDropshipping(bool $dropshipping): static
    {
        $this->dropshipping = $dropshipping;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
            $pricing->setProduct($this);
        }

        return $this;
    }

    public function removePricing(Pricing $pricing): static
    {
        if ($this->pricings->removeElement($pricing)) {
            // set the owning side to null (unless already changed)
            if ($pricing->getProduct() === $this) {
                $pricing->setProduct(null);
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
            $inventory->setReference($this);
        }

        return $this;
    }

    public function removeInventory(Inventorie $inventory): static
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getReference() === $this) {
                $inventory->setReference(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    //lifecycle callbacks
    #[ORM\PrePersist]
    public function onPrePersit(){
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUPdate(){
        $this->updatedAt = new DateTimeImmutable();
    }
}
