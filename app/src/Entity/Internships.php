<?php

namespace App\Entity;

use App\Repository\InternshipsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, InternshipPlayer>
     */
    #[ORM\OneToMany(targetEntity: InternshipPlayer::class, mappedBy: 'internship', orphanRemoval: true)]
    private Collection $internshipPlayers;

    public function __construct()
    {
        $this->internshipPlayers = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, InternshipPlayer>
     */
    public function getInternshipPlayers(): Collection
    {
        return $this->internshipPlayers;
    }

    public function addInternshipPlayer(InternshipPlayer $internshipPlayer): static
    {
        if (!$this->internshipPlayers->contains($internshipPlayer)) {
            $this->internshipPlayers->add($internshipPlayer);
            $internshipPlayer->setInternship($this);
        }

        return $this;
    }

    public function removeInternshipPlayer(InternshipPlayer $internshipPlayer): static
    {
        if ($this->internshipPlayers->removeElement($internshipPlayer)) {
            // set the owning side to null (unless already changed)
            if ($internshipPlayer->getInternship() === $this) {
                $internshipPlayer->setInternship(null);
            }
        }

        return $this;
    }
}
