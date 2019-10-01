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

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class ViewResponder
 */
final class ViewResponder
{
    /** @var Environment */
    protected $templating;

    /**
     * ViewResponder constructor.
     *
     * @param Environment $templating
     */
    public function __construct(
        Environment $templating
    ) {
        $this->templating = $templating;
    }

    public function __invoke(
        string $template,
        array $paramsTemplate = []
    ) {
        return new Response($this->templating->render($template, $paramsTemplate));
    }
}
