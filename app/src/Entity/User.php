<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\NoBadWords;


// Déclare this class as doctrine entity (table 'user' en the BDD)
// eand associate its repository for requests
#[ORM\Entity(repositoryClass: UserRepository::class)]

// Cunicity check on MySQL for the email, double check with symfony validation
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]

//  Symfony validation: chekc the unicity of email and licence nbr before to push it into the bdd 
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déjà avec cette adresse e-mail')]
#[UniqueEntity(fields: ['lienceNbr'], message: 'Ce numéro de licence est déjà utilisé',ignoreNull: true)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'le mail est obligatoire')]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]  
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[NoBadWords]
     #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    #[NoBadWords]
     #[Assert\NotBlank(message: 'Le Nom est obligatoire')]
    private ?string $lastName = null;

   #[ORM\Column(type: 'string', nullable: true)] //can be null for external members
    // #[Assert\NotBlank(message: 'Le numéro de licence est obligatoire')]
    #[Assert\Regex(
        pattern: '/^\d{7}$/',
        message: 'Le numéro de licence doit contenir exactement 7 chiffres'
    )]
    private ?string $lienceNbr = null;


   /**
    * @var Collection<int, Cart>
    */
   #[ORM\Column]
   private ?bool $isVerified = false;

   #[ORM\Column(length: 13)]
  #[Assert\Regex(
    pattern: '/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/',
)]
   private ?string $phoneNbr = null;

   /**
    * @var Collection<int, InternshipPlayer>
    */
   #[ORM\OneToMany(targetEntity: InternshipPlayer::class, mappedBy: 'user')]
   private Collection $internshipPlayers;

   public function __construct()
   {
       $this->isVerified=false;
       $this->internshipPlayers = new ArrayCollection();
   }
    

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
         $roles = $this->roles;

    // default role
    $roles[] = 'ROLE_MEMBRE';

    return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLienceNbr(): ?string
    {
        return $this->lienceNbr;
    }

    public function setLienceNbr(string $lienceNbr): static
    {
        $this->lienceNbr = $lienceNbr;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getPhoneNbr(): ?string
    {
        return $this->phoneNbr;
    }

    public function setPhoneNbr(string $phoneNbr): static
    {
        $this->phoneNbr = $phoneNbr;

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
            $internshipPlayer->setUser($this);
        }

        return $this;
    }

    public function removeInternshipPlayer(InternshipPlayer $internshipPlayer): static
    {
        if ($this->internshipPlayers->removeElement($internshipPlayer)) {
            // set the owning side to null (unless already changed)
            if ($internshipPlayer->getUser() === $this) {
                $internshipPlayer->setUser(null);
            }
        }

        return $this;
    }
}
