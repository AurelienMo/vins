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

use App\Domain\Contact\Forms\ContactType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

final class Resolver
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Environment */
    protected $templating;

    /**
     * Resolver constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param Environment          $templating
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $templating
    ) {
        $this->formFactory = $formFactory;
        $this->templating = $templating;
    }


    public function getForm(Request $request): FormInterface
    {
        return $this->formFactory->create(ContactType::class)->handleRequest($request);
    }

    public function processSubmittingContact($getData)
    {
    }

    public function getTemplatingResponse(FormInterface $form)
    {
        return [
            'code' => $form->getErrors()->count() > 0 ? 400 : 200,
            'html' => $this->templating->render('contact/contact.html.twig', ['form' => $form->createView()])
        ];
    }
}
