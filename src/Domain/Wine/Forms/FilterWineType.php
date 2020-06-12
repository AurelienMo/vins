<?php

namespace App\Domain\Wine\Forms;

use App\Entity\Product;
use App\Entity\VineProfile;
use App\Entity\WineAgreement;
use App\Repository\WineAgreementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterWineType extends AbstractType
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var RequestStack */
    protected $requestStack;

    /** @var WineAgreementRepository */
    protected $wineAgreementRepo;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, WineAgreementRepository $wineAgreementRepo)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->wineAgreementRepo = $wineAgreementRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'profiles',
                ChoiceType::class,
                [
                    'label' => false,
                    'attr' => [
                        'class' => 'mdb-select colorful-select dropdown-danger md-form',
                        'data-label-select-all' => 'Tous les profils',
                    ],
                    'choices' => $this->getProfileByType(),
                    'choice_attr' => function ($choice, $key, $value) {
                        if ($key === 'Profils') {
                            return ['disabled' => true];
                        }



                        if (!$this->requestStack->getCurrentRequest()->query->has('p')) {
                            return [];
                        }

                        $queryParam = explode(',', $this->requestStack->getCurrentRequest()->query->all()['p']);

                        return in_array($key, $queryParam) ? ['selected' => true] : [];
                    },
                    'multiple' => true,
                    'required' => false,
                ]
            )
            ->add(
                'regions',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'mdb-select colorful-select dropdown-danger md-form',
                        'data-label-select-all' => 'Toutes les régions',
                    ],
                    'choice_attr' => function ($choice, $key, $value) {
                        if ($key === 'Régions') {
                            return ['disabled' => true];
                        }

                        if (!$this->requestStack->getCurrentRequest()->query->has('r')) {
                            return [];
                        }

                        $queryParam = explode(',', $this->requestStack->getCurrentRequest()->query->all()['r']);

                        return in_array($key, $queryParam) ? ['selected' => true] : [];
                    },
                    'choices' => $this->getRegions(),
                    'multiple' => true,
                    'required' => false,
                ]
            )
            ->add(
                'accords',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'mdb-select colorful-select dropdown-danger md-form',
                        'data-label-select-all' => 'Tous les accords',
                    ],
                    'choice_attr' => function ($choice, $key, $value) {
                        if ($key === 'Accords') {
                            return ['disabled' => true];
                        }

                        if (!$this->requestStack->getCurrentRequest()->query->has('a')) {
                            return [];
                        }


                        $queryParam = explode(',', $this->requestStack->getCurrentRequest()->query->all()['a']);

                        return in_array($key, $queryParam) ? ['selected' => true] : [];
                    },
                    'choices' => $this->getAccords(),
                    'multiple' => true,
                    'required' => false,
                ]
            )
            ->add(
                'occasions',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'mdb-select colorful-select dropdown-danger md-form',
                        'data-label-select-all' => 'Toutes les occasions',
                    ],
                    'choice_attr' => function ($choice, $key, $value) {
                        if ($key === 'Occasions') {
                            return ['disabled' => true];
                        }

                        if (!$this->requestStack->getCurrentRequest()->query->has('o')) {
                            return [];
                        }


                        $queryParam = explode(',', $this->requestStack->getCurrentRequest()->query->all()['o']);

                        return in_array($key, $queryParam) ? ['selected' => true] : [];
                    },
                    'choices' => $this->getOccasions(),
                    'multiple' => true,
                    'required' => false,
                ]
            )
            ->add(
                'price',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'mdb-select colorful-select dropdown-danger md-form',
                        'data-label-select-all' => 'Tous les prix',
                    ],
                    'placeholder' => 'Prix',
                    'choice_attr' => function ($choice, $key, $value) {
                        return $this->getPrices()[$key] === $this->requestStack->getCurrentRequest()->query->get('pr') ? ['selected' => true] : [];
                    },
                    'choices' => $this->getPrices(),
                    'multiple' => false,
                    'required' => false,
                ]
            )
            ;
    }

    private function getProfileByType()
    {
        $profiles = $this->entityManager->getRepository(VineProfile::class)->findAllOrderedByOrder();

        $profilesList = [
            'Profils' => 'Profils',
            VineProfile::WHITE_TYPE_PROFILE => [],
            VineProfile::PINK_TYPE_PROFILE => [],
            VineProfile::RED_TYPE_PROFILE => []
        ];

        foreach ($profiles as $profile) {
            $profilesList[$profile->getType()][$profile->getName()] = $profile;
        }

        return $profilesList;
    }

    private function getRegions()
    {
        $regions = $this->entityManager->createQueryBuilder()
                            ->from(Product::class, 'p')
                            ->select('p.region')
                            ->where('p.region IS NOT NULL')
                            ->distinct()
                            ->groupBy('p.region')
                            ->getQuery()
                            ->getResult();
        $regionOnProduct = [];
        foreach ($regions as $region) {
            $regionOnProduct[] = $region['region'];
        }
        $allRegions = [
            'Régions' => 'Régions',
            'Alsace' => 'Alsace',
            'Beaujolais' => 'Beaujolais',
            'Bordeaux' => 'Bordeaux',
            'Bourgogne' => 'Bourgogne',
            'Champagne' => 'Champagne',
            'Languedoc' => 'Languedoc',
            'Provence' => 'Provence',
            'Roussilon' => 'Roussilon',
            'Savoie' => 'Savoie',
            'Sud-ouest' => 'Sud-ouest',
            'Loire' => 'Loire',
            'Rhône' => 'Rhône',
        ];
        foreach ($allRegions as $region) {
            if (!in_array($region, $regionOnProduct) && $region !== 'Régions') {
                unset($allRegions[$region]);
            }
        }

        return $allRegions;
    }

    private function getAccords()
    {
        $accords = $this->wineAgreementRepo->getAgreementOrderedByOrder();
        array_unshift($accords, 'Accords');

        $accordsOrdered = [];
        foreach ($accords as $index => $accord) {
            if ($index === 0) {
                $accordsOrdered[$accord] = $accord;
            } else {
                $accordsOrdered[$accord->getName()] = $accord->getName();
            }
        }

        return $accordsOrdered;
    }

    private function getOccasions()
    {
        $products = $this->entityManager->getRepository(Product::class)->selectOccasions();
        $occasions = [
            'Occasions' => 'Occasions',
        ];

        foreach ($products as $product) {
            $occasions[$product['wineService.opportunity']] = $product['wineService.opportunity'];
        }

        return $occasions;
    }

    private function getPrices()
    {
        return [
            '7-9€' => 'minor',
            '10-12€' => 'medium',
            '13-15€' => 'major',
            '>15€' => 'max',
        ];
    }
}
