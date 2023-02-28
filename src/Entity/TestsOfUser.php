<?php

namespace App\Entity;

use App\Repository\TestsOfUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestsOfUserRepository::class)]
class TestsOfUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'testsOfUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'testsOfUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tests $tests = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getTests(): ?Tests
    {
        return $this->tests;
    }

    public function setTests(?Tests $tests): self
    {
        $this->tests = $tests;

        return $this;
    }
}
