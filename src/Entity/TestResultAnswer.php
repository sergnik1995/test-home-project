<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\TestResult;
use App\Entity\TestQuestion;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="result_answer")
 */
class TestResultAnswer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="answer")
     * @var string
     * @Assert\Length(
     *     min=1,
     *     max=2000,
     *     allowEmptyString=false
     * )
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="TestResult",inversedBy="answers")
     * @ORM\JoinColumn(name="result_id", referencedColumnName="id")
     * @var TestResult
     */
    private $result;

    /**
     * @ORM\ManyToOne(targetEntity="TestQuestion")
     * @ORM\JoinColumn(name="question_id",referencedColumnName="id")
     * @var TestQuestion
     */
    private $question;

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
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return TestResult
     */
    public function getResult(): TestResult
    {
        return $this->result;
    }

    /**
     * @param TestResult $result
     */
    public function setResult(TestResult $result): void
    {
        $this->result = $result;
    }

    /**
     * @return TestQuestion
     */
    public function getQuestion(): TestQuestion
    {
        return $this->question;
    }

    /**
     * @param TestQuestion $question
     */
    public function setQuestion(TestQuestion $question): void
    {
        $this->question = $question;
    }
}