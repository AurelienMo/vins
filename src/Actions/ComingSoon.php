<?php

namespace App\Actions;

use App\Domain\Newsletter\Registration\Forms\NewsletterRegistrationType;
use App\Entity\Newsletter;
use App\Repository\NewsletterRepository;
use App\Responders\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prochainement", name="coming-soon")
 */
class ComingSoon
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var NewsletterRepository */
    protected $newsletterRepository;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, NewsletterRepository $newsletterRepository)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->newsletterRepository = $newsletterRepository;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $form = $this->formFactory->create(NewsletterRegistrationType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existRegistration = $this->newsletterRepository->findOneBy(['email' => $form->getData()->getEmail()]);
            if (!$existRegistration instanceof Newsletter) {
                $newsletter = Newsletter::createFromDto($form->getData());
                $this->entityManager->persist($newsletter);
                $this->entityManager->flush();
            }
        }

        return $responder('coming-soon/index.html.twig', ['form' => $form->createView()]);
    }
}
