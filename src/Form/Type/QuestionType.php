<?php

namespace App\Form\Type;

use App\Entity\Test;
use App\Entity\TestQuestion;
use App\Entity\TestQuestionAnswer;
use App\Form\Type\NumberOptionType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Type\FewFromListType;
use App\Form\Type\TextOptionType;
use Symfony\Component\Validator\Constraints\Choice;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', TextType::class, [
                'required' => true
            ])
            ->add('type', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'choices' => TestQuestion::QUESTION_TYPES,
                'property_path' => 'questionType',
                'required' => true
            ])
            ->add('points', NumberType::class)
            ->add('options', CollectionType::class, [
                'property_path' => 'answers',
                'entry_options' => ['label' => false],
                'empty_data' => new ArrayCollection(),
                'allow_add' => true,
                'required' => true
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, [
                $this, 'onPreSubmit'
            ])
            ->get('options')
            ->addViewTransformer(new CallbackTransformer(function ($optionsAsCollection) {
                $optionsAsCollection = $optionsAsCollection ?? new ArrayCollection();
                return $optionsAsCollection->toArray();
            }, function ($optionsAsArray) {
                return new ArrayCollection($optionsAsArray);
            }));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TestQuestion::class,
            'empty_data' => function (FormInterface $form) {
                $question = new TestQuestion();
                $question->setAnswers(new ArrayCollection());
                $question->setQuestion('');
                $question->setPoints(0);
                $question->setQuestionType('few-from-list');
                $question->setTest(new Test());
                return $question;
            }
        ]);
    }

    public function onPreSubmit (FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $options = [
            'property_path' => 'answers',
            'entry_options' => ['label' => false],
            'empty_data' => new ArrayCollection(),
            'allow_add' => true,
            'allow_delete' => true
        ];

        switch ($data['type']) {
            case 'few-from-list':
                $options['entry_type'] = FewFromListType::class;
                break;
            case 'number':
                $options['entry_type'] = NumberOptionType::class;
                break;
            case 'one-from-list':
                $options['entry_type'] = OneFromListType::class;
                $data['options'][$data['options']['true']]['true'] = true;
                unset($data['options']['true']);
                $event->setData($data);
                break;
            case 'text':
                $options['entry_type'] = TextOptionType::class;
                break;
        }

        $form->add('options', CollectionType::class, $options);
    }
}