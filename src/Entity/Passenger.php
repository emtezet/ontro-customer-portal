<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PassengerRepository")
 * @ORM\Table(name="passengers")
 */
class Passenger
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\Choice(callback="getTitles")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Firstname can't be empty!",groups={"new"})
     * @Assert\Length(
     *      max = "20",
     *      maxMessage="Firstname can be max. 20 chars long",groups={"new"}
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Surname can't be empty!",groups={"new"})
     * @Assert\Length(
     *      max = "20",
     *      maxMessage="Surname can be max. 20 chars long",groups={"new"}
     * )
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Passport ID can't be empty!",groups={"new"})
     * @Assert\Length(
     *      max = "20",
     *      maxMessage="Passport ID can be max. 20 chars long",groups={"new"}
     * )
     */
    private $passportId;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Trip", mappedBy="passengers")
     */
    private $trips;

    public function __construct()
    {
        $this->trips = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPassportId(): ?string
    {
        return $this->passportId;
    }

    public function setPassportId(string $passportId): self
    {
        $this->passportId = $passportId;

        return $this;
    }

    /**
     * @return Collection|Trip[]
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Trip $trip): self
    {
        if (!$this->trips->contains($trip)) {
            $this->trips[] = $trip;
            $trip->addPassenger($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trips->contains($trip)) {
            $this->trips->removeElement($trip);
            $trip->removePassenger($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->title .' '. $this->firstname .' '. $this->surname;
    }

    public static function geTitles()
    {
        return ['Mr.','Mrs.','Ms.','Miss'];
    }
}
