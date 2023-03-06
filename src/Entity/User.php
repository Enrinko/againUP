<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'Аккаунт с таким именем уже существует')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: TestsOfUser::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $testsOfUsers;

    public function __construct()
    {
        $this->testsOfUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    /**
     * @return Collection<int, TestsOfUser>
     */
    public function getTestsOfUsers(): Collection
    {
        return $this->testsOfUsers;
    }

    public function addTestsOfUser(TestsOfUser $testsOfUser): self
    {
        if (!$this->testsOfUsers->contains($testsOfUser)) {
            $this->testsOfUsers->add($testsOfUser);
            $testsOfUser->setUser($this);
        }

        return $this;
    }

    public function removeTestsOfUser(TestsOfUser $testsOfUser): self
    {
        if ($this->testsOfUsers->removeElement($testsOfUser)) {
            // set the owning side to null (unless already changed)
            if ($testsOfUser->getUser() === $this) {
                $testsOfUser->setUser(null);
            }
        }

        return $this;
    }
}
