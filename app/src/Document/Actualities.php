<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use App\Repository\ActualitiesRepository;

#[MongoDB\Document(
    repositoryClass: ActualitiesRepository::class,
    collection: "actualites"
)]
// to obtend the day of actuality creation
#[MongoDB\HasLifecycleCallbacks] 

class Actualities
{
    #[MongoDB\Id]
    private ?string $id = null;

    #[MongoDB\Field(type: "string")]
    private ?string $title = null;

    #[MongoDB\Field(type: "string")]
    private ?string $description = null;

    #[MongoDB\Field(type: "string")]
    private ?string $picture = null;

    #[MongoDB\Field(type: "date")]
    private ?\DateTime $createdAt = null;

    #[MongoDB\Field(type: "date")]
    private ?\DateTime $eventOn = null;

   
    public function getId(): ?string
    {
        return $this->id;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }


    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }


    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    #[MongoDB\PrePersist]
        public function setCreatedAtValue(): void

    {
        $this->createdAt = new \DateTime();

    }

   

    public function getEventOn(): ?\DateTime
    {
        return $this->eventOn;
    }

    public function setEventOn(?\DateTime $eventOn): self
    {
        $this->eventOn = $eventOn;
        return $this;
    }
}
