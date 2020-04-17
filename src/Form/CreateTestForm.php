<?php

namespace App\Form;

use App\Entity\Test;
use App\Entity\TestQuestion;
use App\Entity\TestQuestionAnswer;
use App\Entity\TestTag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateTestForm
{
    private $em;

    private $validator;

    private $testData;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->em = $entityManager;
        $this->validator = $validator;
    }

    public function createTest (iterable $testData)
    {
        $this->testData = $testData;

        $test = new Test();
        $test->setName(trim($testData->get('name')));
        $test->setDescription(trim($testData->get('description')));
        $test->setAttempts(0);
        $test->setCreatedAt(time());
        $test->setTime($testData->get('time'));

        $questions = new ArrayCollection();
        foreach ($testData->get('questions') as $questionIndex => $questionData) {
            $question = new TestQuestion();
            $question->setQuestion(trim($questionData['question']));
            $question->setQuestionType($questionData['type']);
            $question->setPoints($questionData['points']);
            $question->setTest($test);
            $question->setPosition($questionIndex);

            $answers = new ArrayCollection();
            foreach ($questionData['options'] as $index => $answerData) {
                $answer = new TestQuestionAnswer();
                $answer->setQuestion($question);

                switch ($questionData['type']) {
                    case 'few-from-list':
                        if($this->validateFewFromListGroup($questionData['true']) and in_array($index, $questionData['true'])) {
                            $answer->setMetadata(['true' => true]);
                        }
                        break;
                    case 'one-from-list':
                        if(is_numeric($questionData['true'])) {
                            if ($index == $questionData['true']) {
                                $answer->setMetadata(['true' => true]);
                            }
                        } else {
                            throw new \Exception('No right answer for one-from-list question');
                        }
                        break;
                    case 'number':
                        if(is_numeric($answerData['answer'])) {
                            $answerData['answer'] = intval($answerData['answer']);
                            if(is_numeric($answerData['accuracy']) ) {
                                $answer->setMetadata(['accuracy' => floatval($answerData['accuracy'])]);
                            } else {
                                throw new \Exception('Accuracy for number question shoud be a number');
                            }
                        } else {
                            throw new \Exception('Number type question answer should be number');
                        }
                        break;
                }

                $errors = $this->validator->validate($answer);

                if($errors->count() > 0) {
                    throw new \Exception($errors->get(0)->getMessage());
                }
                $answer->setAnswer($answerData['answer']);
                $answers->add($answer);
            }
            $errors = $this->validator->validate($question);

            if($errors->count() > 0) {
                throw new \Exception($errors->get(0)->getMessage());
            }
            $question->setAnswers($answers);
            $questions->add($question);
        }

        $test->setQuestions($questions);

        $tags = new ArrayCollection();
        foreach ($testData->get('tags', []) as $tagData) {
            if(isset($tagData['id'])) {
                $tag = $this->em->getRepository(TestTag::class)->find($tagData['id']);

                if($tag === null) {
                    throw new \Exception('Tag id:'.$tagData['id'].' doesn\'t exist');
                }
            } else {
                $tag = $this->em->getRepository(TestTag::class)->findOneBy(['name' => $tagData['name']]);

                if($tag === null) {
                    $tag = new TestTag();
                    $tag->setName($tagData['name']);
                }
            }
            $errors = $this->validator->validate($tag);

            if($errors->count() > 0) {
                throw new \Exception($errors->get(0)->getMessage());
            }
            $tag->addTest($test);
            $tags->add($tag);
        }

        $errors = $this->validator->validate($test);

        if($errors->count() > 0) {
            throw new \Exception($errors->get(0)->getMessage());
        }

        $this->em->persist($test);
        $this->em->flush();

        return $test->getId();
    }

    private function validateFewFromListGroup($data): bool
    {
        if(count($data) === 0) throw new \Exception('No right answers in few-from-list question');

        foreach ($data as $rightAnswer) {
            if(!is_numeric($rightAnswer)) throw new \Exception('Right answer should be a number');
        }

        return true;
    }
}