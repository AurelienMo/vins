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

namespace App\Actions\Common;

use App\Domain\Contact\Resolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Contact
 *
 * @Route("/contact", name="contact_page")
 */
final class Contact
{
    /** @var Resolver */
    protected $resolver;

    /**
     * Contact constructor.
     *
     * @param Resolver $resolver
     */
    public function __construct(
        Resolver $resolver
    ) {
        $this->resolver = $resolver;
    }

    public function __invoke(Request $request, JsonResponder $responder)
    {
        $form = $this->resolver->getForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datasReturned = $this->resolver->processSubmittingContact($request, $form->getData());

            return $responder($datasReturned);
        }

        return $responder($this->resolver->getTemplatingResponse($form));
    }
}
