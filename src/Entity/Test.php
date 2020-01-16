<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TestQuestion;
use App\Entity\TestResult;
use App\Entity\TestTag;

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
     * @ORM\Column(type="integer",name="created_by")
     * @var int
     */
    private $createdBy;

    /**
     * @ORM\Column(type="integer", name="created_at")
     * @var int
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", name="time")
     * @var int
     */
    private $time;

    /**
     * @ORM\Column(type="integer", name="attempts")
     * @var int
     */
    private $attempts;

    /**
     * @ORM\Column(type="string", name="name")
     * @var string
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="TestQuestion",mappedBy="test")
     * @var ArrayCollection
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="TestResult",mappedBy="test")
     * @var ArrayCollection
     */
    private $results;

    /**
     * @ORM\ManyToMany(targetEntity="TestTag",inversedBy="tests")
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
     * @return int
     */
    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy
     */
    public function setCreatedBy(int $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt(int $createdAt): void
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
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     */
    public function setAttempts(int $attempts): void
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
     * @return Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * @param ArrayCollection $questions
     */
    public function setQuestions(ArrayCollection $questions): void
    {
        $this->questions = $questions;
    }

    /**
     * @return Collection
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    /**
     * @param ArrayCollection $results
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
     * @param \App\Entity\TestTag $tag
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
     * @param \App\Entity\TestTag $tag
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