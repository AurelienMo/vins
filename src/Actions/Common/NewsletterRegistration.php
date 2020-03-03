<?php

declare(strict_types=1);

namespace App\Actions\Common;

use App\Domain\Common\Constants\FlashMessage;
use App\Domain\Newsletter\Registration\Forms\NewsletterRegistrationType;
use App\Entity\Newsletter;
use App\Repository\NewsletterRepository;
use App\Responders\JsonResponder;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/registration_newsletter", name="registration_newsletter")
 */
class NewsletterRegistration
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var NewsletterRepository */
    protected $newsletterRepository;

    /** @var FlashBagInterface */
    protected $flashBag;

    /** @var Environment */
    protected $templating;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        NewsletterRepository $newsletterRepository,
        Environment $templating,
        FlashBagInterface $flashBag
    ) {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->newsletterRepository = $newsletterRepository;
        $this->templating = $templating;
        $this->flashBag = $flashBag;
    }


    public function __invoke(
        Request $request,
        ViewResponder $responder,
        JsonResponder $jsonResponder,
        RedirectResponder $redirectResponder
    ): Response {
        $form = $this->formFactory->create(NewsletterRegistrationType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existRegistration = $this->newsletterRepository->findOneBy(['email' => $form->getData()->getEmail()]);
            if (!$existRegistration instanceof Newsletter) {
                $newsletter = Newsletter::createFromDto($form->getData());
                $this->entityManager->persist($newsletter);
                $this->entityManager->flush();
            }

            return $jsonResponder(['code' => 201, 'url' => $request->server->get('HTTP_REFERER')]);
        }

        if ($request->isMethod('POST') && !$form->isValid()) {
            return $redirectResponder('homepage');
        }

        return $responder(
            'newsletter/registration.html.twig',
            ['form' => $form->createView()]
        );
    }
}
