<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Test;
use App\Entity\TestResultAnswer;

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
     * @ORM\Column(type="integer",name="created_by")
     * @var int
     */
    private $createdBy;

    /**
     * @ORM\Column(type="integer",name="created_at")
     * @var int
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer",name="score")
     * @var int
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="Test",inversedBy="results")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * @var Test
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity="TestResultAnswer",mappedBy="result")
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