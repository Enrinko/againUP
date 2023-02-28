<?php

namespace App\Entity;

use App\Repository\TestsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestsRepository::class)]
class Tests
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Questions $questions_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'tests', targetEntity: TestsOfUser::class, orphanRemoval: true)]
    private Collection $testsOfUsers;

    public function __construct()
    {
        $this->testsOfUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionsId(): ?questions
    {
        return $this->questions_id;
    }

    public function setQuestionsId(?questions $questions_id): self
    {
        $this->questions_id = $questions_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
            $testsOfUser->setTests($this);
        }

        return $this;
    }

    public function removeTestsOfUser(TestsOfUser $testsOfUser): self
    {
        if ($this->testsOfUsers->removeElement($testsOfUser)) {
            // set the owning side to null (unless already changed)
            if ($testsOfUser->getTests() === $this) {
                $testsOfUser->setTests(null);
            }
        }

        return $this;
    }
}
