<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\TestQuestionAnswer;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Test;
/**
 * @ORM\Entity
 * @ORM\Table(name="test_question")
 */
class TestQuestion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="question")
     * @var string
     */
    private $question;

    /**
     * @ORM\Column(type="string",name="question_type")
     * @var string
     */
    private $questionType;

    /**
     * @ORM\ManyToOne(targetEntity="Test",inversedBy="questions")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * @var Test
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity="TestQuestionAnswer",mappedBy="question")
     * @var ArrayCollection
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
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
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getQuestionType(): string
    {
        return $this->questionType;
    }

    /**
     * @param string $questionType
     */
    public function setQuestionType(string $questionType): void
    {
        $this->questionType = $questionType;
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