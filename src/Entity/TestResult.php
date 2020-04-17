<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Test;
use App\Entity\TestResultAnswer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="test_result")
 */
class TestResult
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="results")
     * @ORM\JoinColumn(name="created_by",referencedColumnName="id")
     * @var User|null
     */
    private $createdBy;

    /**
     * @ORM\Column(type="integer",name="created_at",nullable=false)
     * @var int
     * @Assert\NotBlank
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer",name="score")
     * @var int
     * @Assert\NotBlank
     */
    private $score;

    /**
     * @ORM\Column(type="integer",name="current_question")
     * @var int|null
     */
    private $currentQuestion;

    /**
     * @ORM\ManyToOne(targetEntity="Test",inversedBy="results")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * @var Test
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity="TestResultAnswer",mappedBy="result", cascade={"persist"})
     * @var ArrayCollection
     */
    private $answers;

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
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return int|null
     */
    public function getCurrentQuestion(): ?int
    {
        return $this->currentQuestion;
    }

    /**
     * @param int|null $currentQuestion
     */
    public function setCurrentQuestion(?int $currentQuestion): void
    {
        $this->currentQuestion = $currentQuestion;
    }

    /**
     * @return Test
     */
    public function getTest(): Test
    {
        return $this->test;
    }

    /**
     * @param Test $test
     */
    public function setTest(Test $test): void
    {
        $this->test = $test;
    }

    /**
     * @return Collection
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    /**
     * @param ArrayCollection $answers
     */
    public function setAnswers(ArrayCollection $answers): void
    {
        $this->answers = $answers;
    }
}