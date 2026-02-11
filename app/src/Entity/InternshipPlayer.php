<?php

namespace App\Entity;

use App\Repository\InternshipPlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InternshipPlayerRepository::class)]
class InternshipPlayer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank(message: 'Le Nom est obligatoire')]
    #[Assert\Length(
    min: 2,
    max: 50,
    minMessage: 'Minimum {{ limit }} caractères',
    maxMessage: 'Maximum {{ limit }} caractères'
)]
    private ?string $LastName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    #[Assert\Length(
    min: 2,
    max: 50,
    minMessage: 'Minimum {{ limit }} caractères',
    maxMessage: 'Maximum {{ limit }} caractères'
)]
    private ?string $FirstName = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le mail est obligatoire')]
    #[Assert\Email(
        message: 'le mail {{ value }} n\'est pas valide.',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message: 'Le portable est obligatoire')]
    #[Assert\Regex(
    pattern: '/^(?:(?:\+|00)33[\s.-]?(?:\(0\)[\s.-]?)?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/',
    message: 'Format invalide'
)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank(message: 'merci de remplir cette case, si tu n\'a pas de classement, séléctionne la case NC')]
    private ?string $SimpleRank = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank(message: 'merci de remplir cette case, si tu n\'a pas de classement, séléctionne la case NC')]
    private ?string $DoubleRank = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank(message: 'merci de remplir cette case, si tu n\'a pas de classement, séléctionne la case NC')]
    private ?string $MixteRank = null;

    #[ORM\ManyToOne(inversedBy: 'internshipPlayers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Internships $internship = null;

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

    public function getInternship(): ?Internships
    {
        return $this->internship;
    }

    public function setInternship(?Internships $internship): static
    {
        $this->internship = $internship;

        return $this;
    }
}
