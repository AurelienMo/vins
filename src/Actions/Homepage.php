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

/**
 * Class Homepage
 *
 * @Route("/", name="homepage")
 */
class Homepage
{
    /** @var Resolver */
    protected $searchResolver;

    /**
     * Homepage constructor.
     *
     * @param Resolver $searchResolver
     */
    public function __construct(
        Resolver $searchResolver
    ) {
        $this->searchResolver = $searchResolver;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $formSearch = $this->searchResolver->getSearchType();


        return $responder(
            'home/index.html.twig',
            [
                'formSearch' => $formSearch->createView(),
            ]
        );
    }
}
