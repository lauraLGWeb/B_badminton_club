<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\NoBadWords;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 155)]
     #[Assert\NotBlank(message: 'le titre est obligatoire')]
    private ?string $title = null;

    #[ORM\Column(length: 505)]
     #[Assert\NotBlank(message: 'la description est obligatoire')]
    #[NoBadWords]
    private ?string $description = null;

    #[Assert\Positive(message: 'Le prix doit être positif')]
    #[ORM\Column(type: 'decimal', precision: 6, scale: 2)]
    #[Assert\NotBlank(message: 'le prix est obligatoire')]
    private ?string $price = null;

   

    #[ORM\Column(length: 255)]
     #[Assert\NotBlank(message: 'l\'image est obligatoire')]
    private ?string $picture = null;

    #[ORM\Column(name: 'has_size')]
    #[Assert\NotNull(message: 'Merci de sélectionner une des deux propositions')]
    private ?bool $hasSize = false;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

 

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getHasSize(): ?bool
    {
        return $this->hasSize;
    }

    public function setHasSize(bool $hasSize): static
    {
        $this->hasSize = $hasSize;

        return $this;
    }

   
}
