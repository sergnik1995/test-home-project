<?php

namespace App\Form\Type;

use App\Entity\TestQuestion;
use App\Entity\TestQuestionAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NumberOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', NumberType::class, [
                'property_path' => 'answer',
                'required' => true
            ])
            ->add('accuracy', NumberType::class, [
                'property_path' => 'metadata',
                'required' => true
            ])
            ->get('accuracy')->addModelTransformer(new CallbackTransformer(function ($data) {
                return $data['accuracy'];
            }, function ($data) {
                return ['accuracy' => $data];
            }));
        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TestQuestionAnswer::class,
            'csrf_protection' => false,
            'empty_data' => function (FormInterface $form) {
                $questionAnswer = new TestQuestionAnswer();
                $questionAnswer->setAnswer(0);
                $questionAnswer->setMetadata(['accuracy' => 0]);
                $questionAnswer->setQuestion(new TestQuestion());
                return $questionAnswer;
            }
        ]);
    }
}