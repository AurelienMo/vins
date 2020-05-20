<?php

declare(strict_types=1);

namespace App\Domain\Cart\Delivery\Forms;

use App\Entity\ConfigurationApp;
use App\Entity\NicheOfDelivery;
use App\Repository\NicheOfDeliveryRepository;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryType extends AbstractType
{
    /** @var NicheOfDeliveryRepository */
    protected $nicheRepository;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        NicheOfDeliveryRepository $nicheRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->nicheRepository = $nicheRepository;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $niche = $data instanceof DeliveryDTO ? $data->getDeliveryNiche() : null;
            if ($niche instanceof NicheOfDelivery) {
                $niche = $this->nicheRepository->find($data->getDeliveryNiche()->getId());
            }
            $form
                ->add(
                    'name',
                    TextType::class,
                    [
                        'label' => 'Nom',
                        'required' => true,
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ]
                )
                ->add(
                    'firstname',
                    TextType::class,
                    [
                        'label' => 'Prénom',
                        'required' => true,
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ]
                )
                ->add(
                    'address',
                    TextType::class,
                    [
                        'label' => 'Rue',
                        'required' => true,
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ]
                )
                ->add(
                    'zipCode',
                    TextType::class,
                    [
                        'label' => 'Code postal',
                        'required' => true,
                        'attr' => [
                            'class' => 'form-control',
                            'pattern' => '^(([1][3][0])|(9[0]))[0-9]{2}$',
                            'title' => 'La livraison est assurée uniquement sur Marseille'
                        ],
                    ]
                )
                ->add(
                    'city',
                    TextType::class,
                    [
                        'label' => 'Ville',
                        'required' => true,
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ]
                )
                ->add(
                    'major',
                    ChoiceType::class,
                    [
                        'label' => false,
                        'choices' => [
                            'Je confirme avoir + de 18 ans pour commander *' => true,
                        ],
                        'label_attr' => [
                            'class' => 'form-check-label',
                        ],
                        'choice_attr' => function ($val, $key, $index) {
                            return ['class' => 'form-check-input'];
                        },
                        'expanded' => true,
                        'multiple' => false,
                    ]
                )
                ->add(
                    'email',
                    EmailType::class,
                    [
                        'required' => true,
                        'label' => 'E-mail',
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ]
                )
                ->add(
                    'phoneNumber',
                    TextType::class,
                    [
                        'required' => true,
                        'label' => 'Téléphone',
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ]
                )
                ->add(
                    'comment',
                    TextareaType::class,
                    [
                        'required' => false,
                        'label' => 'Commentaire',
                        'attr' => [
                            'class' => 'form-control md-textarea',
                            'row' => 2
                        ],
                    ]
                )
                ->add(
                    'typeDelivery',
                    ChoiceType::class,
                    [
                        'label' => 'Je choisis de me faire livrer',
                        'choices' => [
                            $this->getDeliveriesChoices(),
                        ],
                        'label_attr' => [
                            'class' => 'form-check-label',
                        ],
                        'choice_attr' => function ($val, $key, $index) {
                            return ['class' => 'form-check-input'];
                        },
                        'expanded' => true,
                        'multiple' => false,
                    ]
                )
                ->add(
                    'deliveryNiche',
                    EntityType::class,
                    [
                        'class' => NicheOfDelivery::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->where('e.dateNiche >= :date')
                                ->andWhere('e.numberNiche > 0')
                                ->setParameter('date', new \DateTime('+1 days'))
                                ->orderBy('e.dateNiche', 'ASC')
                                ->addOrderBy('e.startAt', 'ASC');
                        },
                        'label' => 'Créneau souhaité',
                        'data' => $niche,
                        'attr' => [
                            'class' => 'mdb-select md-form',
                        ],
                        'required' => false,
                    ]
                )
                ->add(
                    'personIfAbsent',
                    TextType::class,
                    [
                        'label' => 'Nom de la personne',
                        'required' => false,
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ]
                );
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => DeliveryDTO::class,
            ]
        );
    }

    private function getDeliveriesChoices()
    {
        /** @var ConfigurationApp $configurationApp */
        $configurationApp = current($this->entityManager->getRepository(ConfigurationApp::class)->findAll());

        if ($configurationApp->isDeliveryOffer()) {
            return [
                'Livraison offerte sous 3 jours ouvrés, entre 15h et 19h' => 'free',
                'Sur un créneau horaire choisi pour 6€' => 'express',
            ];
        }

        return [
            'Sous 3 jours, entre 15h et 19h, pour 4€' => 'basic',
            'Sur un créneau horaire choisi pour 6€' => 'express',
        ];
    }
}
