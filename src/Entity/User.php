<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Regex(
      pattern: '/^[a-zA-Z0-9_]+$/'
    )]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @var Collection<int, Draw>
     */
    #[ORM\ManyToMany(targetEntity: Draw::class, mappedBy: 'users')]
    private Collection $draw;

    #[ORM\Column(nullable: true, length: 255)]
    private ?string $avatar = null;

    public function __construct()
    {
        $this->draw = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
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
        // Si tu stockes des données temporaires sensibles, nettoie-les ici
    }



    public function addDraw(Draw $draw): static
    {
        if (!$this->draw->contains($draw)) {
            $this->draw->add($draw);
            $draw->setUsers($this);
        }

        return $this;
    }

    public function removeDraw(Draw $draw): static
    {
        if ($this->draws->removeElement($draw)) {
            // set the owning side to null (unless already changed)
            if ($draw->getUsers() === $this) {
                $draw->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Draw>
     */
    public function getDraw(): Collection
    {
        return $this->draw;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }
}
