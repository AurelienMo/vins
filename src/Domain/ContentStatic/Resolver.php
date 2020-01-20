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

namespace App\Domain\ContentStatic;

use Twig\Environment;

final class Resolver
{
    /** @var Environment */
    protected $templating;

    /**
     * Resolver constructor.
     *
     * @param Environment $templating
     */
    public function __construct(
        Environment $templating
    ) {
        $this->templating = $templating;
    }

    public function getContentPage(string $page): array
    {
        $code = 200;
        $html = $this->templating->render('static/'.$page.'.html.twig');

        switch ($page) {
            case 'cgv':
                break;
            default:
                $code = 404;
                $html = '<p>La page demandée n\'existe pas</p>';
                break;
        }

        return [
            'code' => $code,
            'html' => $html,
        ];
    }
}
