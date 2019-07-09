<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
 */
class Trip
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\NotBlank(message="Departure airport can't be empty!",groups={"new"})
     * @Assert\Length(
     *      max = "3",
     *      maxMessage="Departure airport can be max. 3 chars long",groups={"new"}
     * )
     */
    private $fromAirport;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\NotBlank(message="Destination airport can't be empty!",groups={"new"})
     * @Assert\Length(
     *      max = "3",
     *      maxMessage="Destination airport can be max. 3 chars long!",groups={"new"}
     * )
     */
    private $toAirport;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Departure date is invalid!",groups={"new"})
     * @Assert\DateTime(message="Departure date is invalid!",groups={"new"})
     */
    private $departure;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Arrival date is invalid!",groups={"new"})
     * @Assert\DateTime(message="Arrival date is invalid!",groups={"new"})
     */
    private $arrival;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Passenger", inversedBy="trips")
     * @Assert\Count(min="1", minMessage="Trip must have at least one passenger!",groups={"new"})
     */
    private $passengers;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromAirport(): ?string
    {
        return $this->fromAirport;
    }

    public function setFromAirport(?string $fromAirport): self
    {
        $this->fromAirport = $fromAirport;

        return $this;
    }

    public function getToAirport(): ?string
    {
        return $this->toAirport;
    }

    public function setToAirport(?string $toAirport): self
    {
        $this->toAirport = $toAirport;

        return $this;
    }

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    public function setDeparture(?\DateTimeInterface $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getArrival(): ?\DateTimeInterface
    {
        return $this->arrival;
    }

    public function setArrival(?\DateTimeInterface $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * @return Collection|Passenger[]
     */
    public function getPassengers(): ?Collection
    {
        return $this->passengers;
    }

    public function addPassenger(?Passenger $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers[] = $passenger;
        }

        return $this;
    }

    public function removePassenger(?Passenger $passenger): self
    {
        if ($this->passengers->contains($passenger)) {
            $this->passengers->removeElement($passenger);
        }

        return $this;
    }
}
