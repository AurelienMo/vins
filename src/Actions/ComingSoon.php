<?php

namespace App\Actions;

use App\Domain\Newsletter\Registration\Forms\NewsletterRegistrationType;
use App\Entity\Newsletter;
use App\Repository\NewsletterRepository;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
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

    /** @var FlashBagInterface */
    protected $flash;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, NewsletterRepository $newsletterRepository, FlashBagInterface $flash)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->newsletterRepository = $newsletterRepository;
        $this->flash = $flash;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $form = $this->formFactory->create(NewsletterRegistrationType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existRegistration = $this->newsletterRepository->findOneBy(['email' => $form->getData()->getEmail()]);
            if (!$existRegistration instanceof Newsletter) {
                $newsletter = Newsletter::createFromDto($form->getData());
                $this->flash->add('success', 'Votre inscription à la newsletter a bien été prise en compte.');
                $this->entityManager->persist($newsletter);
                $this->entityManager->flush();

                return $redirectResponder('coming-soon');
            }
        }

        return $responder('coming-soon/index.html.twig', ['form' => $form->createView()]);
    }
}
