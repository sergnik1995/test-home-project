<?php

namespace App\Form\Type;

use App\Entity\Test;
use App\Entity\TestQuestion;
use App\Entity\TestTag;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Type\QuestionType;
use App\Form\Type\TagType;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true
            ])
            ->add('time', NumberType::class)
            ->add('description', TextType::class)
            ->add('questions', CollectionType::class, [
                'entry_type' => QuestionType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'required' => true
            ])
            ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $test = $event->getData();

                foreach ($test->getQuestions() as $question) {
                    $question->setTest($test);

                    foreach ($question->getAnswers() as $answer) {
                        $answer->setQuestion($question);
                    }
                }
            })
            ->get('questions')
            ->addViewTransformer(new CallbackTransformer(function ($questionsAsCollection) {
               return $questionsAsCollection ? $questionsAsCollection->toArray() : [];
            }, function ($questionsAsArray) {
               return new ArrayCollection($questionsAsArray);
            }));
        $builder
            ->get('tags')
            ->addViewTransformer(new CallbackTransformer(function ($tagsAsCollection) {
                return $tagsAsCollection ? $tagsAsCollection->toArray() : [];
            }, function ($tagsAsArray) {
                return new ArrayCollection($tagsAsArray);
            }));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
            'csrf_protection' => false,
            'empty_data' => function (FormInterface $form) {
                $test = new Test();
                $test->setName('');
                $test->setDescription('');
                $test->setTime(0);
                $test->setCreatedAt(time());
                $test->setQuestions(new ArrayCollection());
                return $test;
            }
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}