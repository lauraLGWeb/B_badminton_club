<?php

namespace App\Entity;

use App\Repository\InternshipPlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InternshipPlayerRepository::class)]
class InternshipPlayer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $LastName = null;

    #[ORM\Column(length: 50)]
    private ?string $FirstName = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 3)]
    private ?string $SimpleRank = null;

    #[ORM\Column(length: 3)]
    private ?string $DoubleRank = null;

    #[ORM\Column(length: 3)]
    private ?string $MixteRank = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getSimpleRank(): ?string
    {
        return $this->SimpleRank;
    }

    public function setSimpleRank(string $SimpleRank): static
    {
        $this->SimpleRank = $SimpleRank;

        return $this;
    }

    public function getDoubleRank(): ?string
    {
        return $this->DoubleRank;
    }

    public function setDoubleRank(string $DoubleRank): static
    {
        $this->DoubleRank = $DoubleRank;

        return $this;
    }

    public function getMixteRank(): ?string
    {
        return $this->MixteRank;
    }

    public function setMixteRank(string $MixteRank): static
    {
        $this->MixteRank = $MixteRank;

        return $this;
    }
}
