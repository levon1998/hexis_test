<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="vehicles")
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
class Vehicle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Brand $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Vendor::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Vendor $vendor;

    /**
     * @ORM\OneToMany (targetEntity=VehicleAttribute::class, mappedBy="vehicle")
     */
    private $attributes;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private bool $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt;

    /**
     * Construct for Vehicle class.
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \App\Entity\Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @param \App\Entity\Brand|null $brand
     *
     * @return $this
     */
    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return \App\Entity\Vendor|null
     */
    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    /**
     * @param \App\Entity\Vendor|null $vendor
     *
     * @return $this
     */
    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * @return Collection|Attribute[]
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    /**
     * @param \App\Entity\Attribute $attribute
     *
     * @return $this
     */
    public function addAttributes(Attribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
        }

        return $this;
    }

    /**
     * @param \App\Entity\Attribute $attribute
     *
     * @return $this
     */
    public function removeAttributes(Attribute $attribute): self
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
