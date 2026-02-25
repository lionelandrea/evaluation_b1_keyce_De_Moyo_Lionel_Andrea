<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    
    #[ORM\ManyToMany(targetEntity: Game::class)]
    #[ORM\JoinTable(name: 'user_wishlist')]
    private Collection $wishlistGames;

    public function __construct()
    {
        $this->wishlistGames = new ArrayCollection();
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_values(array_unique($roles));
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    // ✅ Wishlist helpers
    public function getWishlistGames(): Collection
    {
        return $this->wishlistGames;
    }

    public function addWishlistGame(Game $game): static
    {
        if (!$this->wishlistGames->contains($game)) {
            $this->wishlistGames->add($game);
        }
        return $this;
    }

    public function removeWishlistGame(Game $game): static
    {
        $this->wishlistGames->removeElement($game);
        return $this;
    }

    public function hasInWishlist(Game $game): bool
    {
        return $this->wishlistGames->contains($game);
    }

    public function __toString(): string
    {
        return $this->email ?? 'User';
    }
}