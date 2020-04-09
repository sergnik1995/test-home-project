<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\TestQuestion;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="question_answer")
 */
class TestQuestionAnswer
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
     *     min=0,
     *     max=2000,
     *     allowEmptyString=false
     * )
     */
    private $answer;

    /**
     * @ORM\Column(type="simple_array",name="metadata")
     * @var array
     */
    private $metadata;

    /**
     * @ORM\ManyToOne(targetEntity="TestQuestion",inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
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
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata(array $metadata): void
    {
        $this->metadata = $metadata;
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