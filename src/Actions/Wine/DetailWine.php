<?php

declare(strict_types=1);

namespace App\Actions\Wine;

use App\Domain\Opinion\Forms\OpinionType;
use App\Entity\Opinion;
use App\Repository\ProductRepository;
use App\Responders\JsonResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/wine/{id}", name="detail_wine")
 */
class DetailWine
{
    /** @var Environment */
    protected $templating;

    /** @var ProductRepository */
    protected $wineRepository;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        Environment $templating,
        ProductRepository $wineRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->templating = $templating;
        $this->wineRepository = $wineRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }


    public function __invoke(Request $request, JsonResponder $responder)
    {
        $wine = $this->wineRepository->find($request->attributes->get('id'));
        $form = $this->formFactory->create(OpinionType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $opinion = Opinion::createFromDTO($form->getData(), $wine);
            $this->entityManager->persist($opinion);
            $this->entityManager->flush();

            return $responder(
                [
                    'code' => 201,
                    'url' => $request->server->get('HTTP_REFERER'),
                ]
            );
        }

        return $responder(
            [
                'code' => Response::HTTP_OK,
                'html' => $this->templating->render(
                    'wines/detail.html.twig',
                    [
                        'wine' => $wine,
                        'form' => $form->createView(),
                    ]
                )
            ]
        );
    }
}
