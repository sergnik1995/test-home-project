<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TestQuestion;
use App\Entity\TestResult;
use App\Entity\TestTag;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="test")
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="tests")
     * @ORM\JoinColumn(name="created_by",referencedColumnName="id")
     * @var User|null
     */
    private $createdBy;

    /**
     * @ORM\Column(type="integer", name="created_at", nullable=true)
     * @var int
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", name="time")
     * @var int
     */
    private $time;

    /**
     * @ORM\Column(type="integer", name="attempts", nullable=true)
     * @var int
     */
    private $attempts;

    /**
     * @ORM\Column(type="string", name="name")
     * @var string
     * @Assert\Length(
     *     min = 1,
     *     max = 255,
     *     allowEmptyString = false
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", name="description")
     * @var string
     * @Assert\Length(
     *     min=0,
     *     max=500,
     *     allowEmptyString = true
     * )
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="TestQuestion",mappedBy="test",cascade={"persist"})
     * @var ArrayCollection|TestQuestion[]
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="TestResult",mappedBy="test")
     * @var ArrayCollection|TestResult[]
     */
    private $results;

    /**
     * @ORM\ManyToMany(targetEntity="TestTag",inversedBy="tests",cascade={"persist"})
     * @ORM\JoinTable(
     *     name="test_tag",
     *     joinColumns={
     *         @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *     }
     * )
     * @var Collection|TestTag[]
     */
    private $tags;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->results = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User|null
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * @param User|null $createdBy
     */
    public function setCreatedBy(?User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return int|null
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @param int|null $createdAt
     */
    public function setCreatedAt(?int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime(int $time): void
    {
        $this->time = $time;
    }

    /**
     * @return int|null
     */
    public function getAttempts(): ?int
    {
        return $this->attempts;
    }

    /**
     * @param int|null $attempts
     */
    public function setAttempts(?int $attempts): void
    {
        $this->attempts = $attempts;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return TestQuestion[]|Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * @param TestQuestion[]|ArrayCollection $questions
     */
    public function setQuestions(ArrayCollection $questions): void
    {
        $this->questions = $questions;
    }

    /**
     * @return TestResult[]|Collection
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    /**
     * @param ArrayCollection|TestResult[] $results
     */
    public function setResults(ArrayCollection $results): void
    {
        $this->results = $results;
    }

    /**
     * @return TestTag[]|Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param TestTag[]|Collection $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @param TestTag $tag
     */
    public function addTag(TestTag $tag)
    {
        if($this->tags->contains($tag)) {
            return;
        }

        $this->tags->add($tag);
        $tag->addTest($this);
    }

    /**
     * @param TestTag $tag
     */
    public function removeTag(TestTag $tag)
    {
        if(!$this->tags->contains($tag)) {
            return;
        }

        $this->tags->removeElement($tag);
        $tag->removeTest($this);
    }
}