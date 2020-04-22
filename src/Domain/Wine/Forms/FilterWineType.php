<?php

namespace App\Domain\Wine\Forms;

use App\Entity\Product;
use App\Entity\VineProfile;
use App\Entity\WineAgreement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterWineType extends AbstractType
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var RequestStack */
    protected $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
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
                        'class' => 'mdb-select colorful-select dropdown-primary md-form',
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
                        'class' => 'mdb-select colorful-select dropdown-primary md-form',
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
                        'class' => 'mdb-select colorful-select dropdown-primary md-form',
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
                        'class' => 'mdb-select colorful-select dropdown-primary md-form',
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
            ;
    }

    private function getProfileByType()
    {
        $profiles = $this->entityManager->getRepository(VineProfile::class)->findAll();

        $base = [
            'Profils' => 'Profils',
        ];
        $whiteList = [
            'Les blancs' => 'Les blancs',
        ];
        $pinkList = [
            'Les rosés' => 'Les rosés',
        ];
        $redList = [
            'Les rouges' => 'Les rouges',
        ];

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



        /** @var VineProfile $profile */
        foreach ($profiles as $profile) {
            switch ($profile->getType()) {
                case VineProfile::WHITE_TYPE_PROFILE:
                    $whiteList[$profile->getName()] = $profile->getName();
                    break;
                case VineProfile::PINK_TYPE_PROFILE:
                    $pinkList[$profile->getName()] = $profile->getName();
                    break;
                case VineProfile::RED_TYPE_PROFILE:
                    $redList[$profile->getName()] = $profile->getName();
                    break;
            }
        }

        return array_merge($base, $whiteList, $pinkList, $redList);
    }

    private function getRegions()
    {
        return [
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
            'Val de loire' => 'Val de loire',
            'Vallée du Rhône' => 'Vallée du Rhône',
        ];
    }

    private function getAccords()
    {
        $accords = $this->entityManager->getRepository(WineAgreement::class)->findAll();
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
}
