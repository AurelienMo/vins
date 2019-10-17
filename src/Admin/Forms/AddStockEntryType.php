<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Admin\Forms;

use App\Entity\StockEntry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddStockEntryType
 */
class AddStockEntryType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $form->add(
                'quantity',
                IntegerType::class,
                [
                    'label' => false,
                    'disabled' => !is_null($data) ? true : false,
                ]
            );
            if (!is_null($data)) {
                $form
                    ->add(
                        'createdAt',
                        DateTimeType::class,
                        [
                            'widget' => 'single_text',
                            'format' => 'dd-MM-yyyy',
                            'disabled' => true,
                            'label' => 'Date opération'
                        ]
                    )
                ;
            }
        });
//
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'data_class' => StockEntry::class,
                ]
            );
    }
}
