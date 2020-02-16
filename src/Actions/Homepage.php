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
use App\Repository\SliderHomeRepository;
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

    /** @var SliderHomeRepository */
    protected $sliderHomeRepository;

    public function __construct(SliderHomeRepository $sliderHomeRepository)
    {
        $this->sliderHomeRepository = $sliderHomeRepository;
    }


    public function __invoke(Request $request, ViewResponder $responder)
    {
//        $formSearch = $this->searchResolver->getSearchType();
        $sliders = $this->sliderHomeRepository->findAllOrderedByOrder();

        return $responder(
            'home/index.html.twig',
            [
                'sliders' => $sliders,
            ]
        );
    }
}
