<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <aurelien.morvan@infostrates.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Contact\Forms;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ContactType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom',
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'label' => 'Email',
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'phoneNumber',
                TextType::class,
                [
                    'label' => 'N° Téléphone',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'orderNumber',
                TextType::class,
                [
                    'label' => 'N° commande',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'subject',
                ChoiceType::class,
                [
                    'label' => false,
                    'choices' => Contact::LIST_SUBJECT,
                    'placeholder' => 'Sujet',
                    'attr' => [
                        'class' => 'browser-default custom-select'
                    ]
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => 'Votre message',
                    'attr' => [
                        'rows' => 3,
                        'class' => 'form-control md-textarea mb-3'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'data_class' => ContactDTO::class,
                ]
            );
    }
}
