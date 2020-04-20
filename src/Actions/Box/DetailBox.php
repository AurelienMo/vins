<?php

namespace App\Actions\Box;

use App\Domain\Opinion\Forms\OpinionType;
use App\Entity\Opinion;
use App\Repository\BoxWineRepository;
use App\Responders\JsonResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/boxs/{id}", name="detail_box")
 */
class DetailBox
{
    /** @var BoxWineRepository */
    protected $boxRepository;

    /** @var Environment */
    protected $templating;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        BoxWineRepository $boxRepository,
        Environment $templating,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->boxRepository = $boxRepository;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    public function __invoke(Request $request, JsonResponder $responder)
    {
        $box = $this->boxRepository->find($request->attributes->get('id'));
        $form = $this->formFactory->create(OpinionType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $opinion = Opinion::createFromDTO($form->getData(), $box);
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
                    'box/detail.html.twig',
                    [
                        'box' => $box,
                        'form' => $form->createView(),
                    ]
                )
            ]
        );
    }
}
