<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <aurelien.morvan@infostrates.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Contact;

use App\Domain\Common\Constants\FlashMessage;
use App\Domain\Common\Subscribers\Events\FlashMessageEvent;
use App\Domain\Contact\Forms\ContactDTO;
use App\Domain\Contact\Forms\ContactType;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

final class Resolver
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Environment */
    protected $templating;

    /** @var ContactRepository */
    protected $contactRepository;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * Resolver constructor.
     *
     * @param FormFactoryInterface     $formFactory
     * @param Environment              $templating
     * @param ContactRepository        $contactRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $templating,
        ContactRepository $contactRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->contactRepository = $contactRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getForm(Request $request): FormInterface
    {
        return $this->formFactory->create(ContactType::class)->handleRequest($request);
    }

    public function processSubmittingContact(Request $request, ContactDTO $dto)
    {
        $contact = Contact::create($dto);
        try {
            $this->contactRepository->persist($contact);
            $this->contactRepository->flush();
        } catch (Exception $e) {
        }

        $this->eventDispatcher->dispatch(new FlashMessageEvent('success', FlashMessage::SUCCESS_CONTACT));

        return [
            'code' => 200,
            'url' => $request->server->get('HTTP_REFERER'),
        ];
    }

    public function getTemplatingResponse(FormInterface $form)
    {
        return [
            'code' => 200,
            'html' => $this->templating->render('contact/contact.html.twig', ['form' => $form->createView()])
        ];
    }
}
