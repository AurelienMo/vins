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

use App\Domain\ContentStatic\Resolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StaticPage
 *
 * @Route("/static/{page}", name="static_page")
 */
final class StaticPage
{
    /** @var Resolver */
    protected $resolver;

    /**
     * StaticPage constructor.
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
        $typePage = $request->attributes->get('page');
        $datas = $this->resolver->getContentPage($typePage);

        return $responder($datas);
    }
}
