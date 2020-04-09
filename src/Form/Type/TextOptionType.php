<?php

namespace App\Form\Type;

use App\Entity\TestQuestion;
use App\Entity\TestQuestionAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer', TextType::class, [
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TestQuestionAnswer::class,
            'csrf_protection' => false,
            'empty_data' => function (FormInterface $form) {
                $questionAnswer = new TestQuestionAnswer();
                $questionAnswer->setQuestion(new TestQuestion());
                $questionAnswer->setAnswer('');
                $questionAnswer->setMetadata([]);
                return $questionAnswer;
            }
        ]);
    }
}