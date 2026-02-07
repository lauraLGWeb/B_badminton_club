<?php

namespace App\Entity;

use App\Repository\InternshipsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InternshipsRepository::class)]
class Internships
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $internshipTitle = null;

   #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTime = null;


    #[ORM\Column(length: 255)]
    private ?string $gymnase = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $price = null;

    #[ORM\Column]
    private ?int $maxPlayersNbr = null;

    #[ORM\Column]
    private ?int $alreadyBooked = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInternshipTitle(): ?string
    {
        return $this->internshipTitle;
    }

    public function setInternshipTitle(string $internshipTitle): static
    {
        $this->internshipTitle = $internshipTitle;

        return $this;
    }

    public function getDateTime(): ?\DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }



    public function getGymnase(): ?string
    {
        return $this->gymnase;
    }

    public function setGymnase(string $gymnase): static
    {
        $this->gymnase = $gymnase;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getMaxPlayersNbr(): ?int
    {
        return $this->maxPlayersNbr;
    }

    public function setMaxPlayersNbr(int $maxPlayersNbr): static
    {
        $this->maxPlayersNbr = $maxPlayersNbr;

        return $this;
    }

    public function getAlreadyBooked(): ?int
    {
        return $this->alreadyBooked;
    }

    public function setAlreadyBooked(int $alreadyBooked): static
    {
        $this->alreadyBooked = $alreadyBooked;

        return $this;
    }
}
