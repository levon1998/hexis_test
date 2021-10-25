<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="brands")
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
class Brand
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
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private ?bool $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Vehicle::class, mappedBy="brand", orphanRemoval=true)
     */
    private ArrayCollection $vehicles;

    /**
     * Construct of Brand class.
     */
    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
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

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeInterface $created_at
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    /**
     * @param \App\Entity\Vehicle $vehicle
     *
     * @return $this
     */
    public function addVehicle(Vehicle $vehicle): self
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setBrand($this);
        }

        return $this;
    }

    /**
     * @param \App\Entity\Vehicle $vehicle
     *
     * @return $this
     */
    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getBrand() === $this) {
                $vehicle->setBrand(null);
            }
        }

        return $this;
    }
}
