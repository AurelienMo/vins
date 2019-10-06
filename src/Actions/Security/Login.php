<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Actions\Security;

use App\Domain\Account\Login\Resolver;
use App\Responders\JsonResponder;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class Login
 *
 * @Route("/se-connecter", name="security_login")
 */
final class Login
{
    /** @var Resolver */
    protected $resolver;

    /**
     * Login constructor.
     *
     * @param Resolver $resolver
     */
    public function __construct(
        Resolver $resolver
    ) {
        $this->resolver = $resolver;
    }

    public function __invoke(ViewResponder $responder)
    {
        $form = $this->resolver->getFormType();

        return $responder(
            $this->resolver->getTemplate(),
            [
                'form' => $form->createView(),
                'error' => $this->resolver->getLastAuthErrors(),
            ]
        );
    }
}
