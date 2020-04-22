<?php

declare(strict_types=1);

namespace App\Actions\Wine;

use App\Domain\Wine\Forms\FilterWineType;
use App\Entity\VineProfile;
use App\Entity\WineAgreement;
use App\Repository\ProductRepository;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/les-vins", name="wine_list")
 */
class WineList
{
    /** @var ProductRepository */
    protected $wineRepository;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var FormFactoryInterface */
    protected $formFactory;

    public function __construct(
        ProductRepository $wineRepository,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory
    ) {
        $this->wineRepository = $wineRepository;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $wines = $this->wineRepository->findOnlyActive($request->query->all());

        $form = $this->formFactory->create(FilterWineType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileFilter = implode(',', $form->getData()['profiles']);
            $regionsFilter = implode(',', $form->getData()['regions']);
            $accordsFilter = implode(',', $form->getData()['accords']);
            $occasionsFilter = implode(',', $form->getData()['occasions']);

            return $redirectResponder(
                'wine_list',
                [
                    'p' => $profileFilter,
                    'r' => $regionsFilter,
                    'a' => $accordsFilter,
                    'o' => $occasionsFilter,
                ]
            );
        }

        return $responder(
            'wines/list.html.twig',
            [
                'wines' => $wines,
                'accords' => $this->getAccords(),
                'form' => $form->createView(),
            ]
        );
    }

    private function getAccords()
    {
        return $this->entityManager->getRepository(WineAgreement::class)->findAll();
    }
}
