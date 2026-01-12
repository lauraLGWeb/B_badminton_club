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


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déja aevc cette adresse mail')]
#[UniqueEntity(fields: ['lienceNbr'], message: 'ce numéro de licence est déja utilisé')]

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
     #[Assert\NotBlank(message: 'Le mot de passe est obligatoire')]
    #[Assert\PasswordStrength(
        message: 'Your password is too easy to guess. Company\'s security policy requires to use a stronger password.'
    )]

    private ?string $password = null;

    #[ORM\Column(length: 50)]
     #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
     #[Assert\NotBlank(message: 'Le Nom est obligatoire')]
    private ?string $lastName = null;

   #[ORM\Column(type: 'bigint')]
    #[Assert\NotBlank(message: 'Le numéro de licence est obligatoire')]
    #[Assert\Positive(message: 'Le numéro de licence doit être positif')]
    #[Assert\Length(
    min: 7,
    max: 7,
    exactMessage: 'Le numéro de licence doit contenir exactement {{ limit }} chiffres'
)]

    private ?string $lienceNbr = null;

   /**
    * @var Collection<int, Cart>
    */
   #[ORM\OneToMany(targetEntity: Cart::class, mappedBy: 'user')]
   private Collection $carts;

   public function __construct()
   {
       $this->carts = new ArrayCollection();
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

    // rôle par défaut
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
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
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

    public function getLienceNbr(): ?int
    {
        return $this->lienceNbr;
    }

    public function setLienceNbr(int $lienceNbr): static
    {
        $this->lienceNbr = $lienceNbr;

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): static
    {
        if (!$this->carts->contains($cart)) {
            $this->carts->add($cart);
            $cart->setUser($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->carts->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getUser() === $this) {
                $cart->setUser(null);
            }
        }

        return $this;
    }
}
