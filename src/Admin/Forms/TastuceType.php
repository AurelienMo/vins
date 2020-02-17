<?php

declare(strict_types=1);

namespace App\Admin\Forms;

use App\Entity\Tastuce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class TastuceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'pdfFile',
                VichFileType::class,
                [
                    'required' => false,
                    'allow_delete' => true,
                    'asset_helper' => true,
                    'label' => 'Fichier pdf'
                ]
            )
            ->add(
                'textLink',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Nom du lien'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'data_class' => Tastuce::class,
                ]
            );
    }
}
