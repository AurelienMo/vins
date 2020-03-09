<?php

declare(strict_types=1);

namespace App\Domain\Opinion\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpinionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Votre nom',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'rate',
                IntegerType::class,
                [
                    'label' => 'Votre note',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                        'min' => 0,
                        'max' => 5,
                    ]
                ]
            )
            ->add(
                'content',
                TextareaType::class,
                [
                    'label' => 'Votre avis',
                    'required' => false,
                    'attr' => [
                        'class' => 'md-textarea form-control'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'data_class' => NewOpinionDTO::class,
                ]
            );
    }
}
