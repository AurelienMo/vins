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
use App\Repository\GlobalConfigurationRepository;
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

    /** @var GlobalConfigurationRepository */
    protected $globalRepository;

    public function __construct(
        SliderHomeRepository $sliderHomeRepository,
        GlobalConfigurationRepository $globalRepository
    ) {
        $this->sliderHomeRepository = $sliderHomeRepository;
        $this->globalRepository = $globalRepository;
    }


    public function __invoke(Request $request, ViewResponder $responder)
    {
        $sliders = $this->sliderHomeRepository->findAllOrderedByOrder();
        $globalConfig = $this->globalRepository->findLatest();

        return $responder(
            'home/index.html.twig',
            [
                'sliders' => $sliders,
                'globalConf' => $globalConfig,
            ]
        );
    }
}
