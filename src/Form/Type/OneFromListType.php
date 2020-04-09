<?php

namespace App\Form\Type;

use App\Entity\TestQuestion;
use App\Entity\TestQuestionAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Form\FormEvent;

class OneFromListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer', TextType::class, [
                'required' => true
            ])
            ->add('true', RadioType::class, [
                'property_path' => 'metadata',
                'required' => true
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, [
                $this, 'onPreSubmit'
            ])
            ->get('true')->addModelTransformer(new CallbackTransformer(function ($data) {
                return $data['true'];
            }, function ($data) {
                return ['true' => $data];
            }));
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
                $questionAnswer->setMetadata(['true' => false]);
                return $questionAnswer;
            }
        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
    }
}