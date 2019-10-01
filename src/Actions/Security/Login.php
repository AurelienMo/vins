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
    /** @var Environment */
    protected $templating;

    /**
     * Login constructor.
     *
     * @param Environment $templating
     */
    public function __construct(
        Environment $templating
    ) {
        $this->templating = $templating;
    }

    public function __invoke()
    {
        $statusCode = 400;
        if ($statusCode !== 200) {
            return new JsonResponse(
                [
                    'html' => $this->templating->render('security/error.html.twig'),
                ],
                400
            );
        }
        return new JsonResponse(
            [
                'html' => $this->templating->render('security/login.html.twig'),
            ]
        );
    }
}
