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

namespace App\Actions;

use App\Domain\Search\Resolver;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Wine\Resolver as WineResolver;

/**
 * Class Homepage
 *
 * @Route("/", name="homepage")
 */
class Homepage
{
    /** @var Resolver */
    protected $searchResolver;

    /** @var WineResolver */
    protected $wineResolver;

    /**
     * Homepage constructor.
     *
     * @param Resolver     $searchResolver
     * @param WineResolver $wineResolver
     */
    public function __construct(
        Resolver $searchResolver,
        WineResolver $wineResolver
    ) {
        $this->searchResolver = $searchResolver;
        $this->wineResolver = $wineResolver;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $formSearch = $this->searchResolver->getSearchType();

        return $responder(
            'home/index.html.twig',
            [
                'formSearch' => $formSearch->createView(),
                'promotes' => $this->wineResolver->findPromote(),
                'wines' => $this->wineResolver->findAllProducts(),
            ]
        );
    }
}
