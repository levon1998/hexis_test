<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\VendorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="vendors")
 * @ORM\Entity(repositoryClass=VendorRepository::class)
 */
class Vendor
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
     * @ORM\Column(type="string", length=255)
     */
    private ?string $address;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private ?bool $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Vehicle::class, mappedBy="vendor")
     */
    private $vehicles;

    /**
     * Construct of Vendor class.
     */
    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress() : ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return $this
     */
    public function setAddress(string $address) : self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getStatus() : ?bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function setStatus(bool $status) : self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt() : ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt) : self
    {
        $this->createdAt = $createdAt;

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
            $vehicle->setVendor($this);
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
            if ($vehicle->getVendor() === $this) {
                $vehicle->setVendor(null);
            }
        }

        return $this;
    }

    /**
     * Generates the magic method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
