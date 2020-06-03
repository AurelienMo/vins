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

namespace App\Actions\WineProfile;

use App\Repository\BreadcrumbRepository;
use App\Repository\WineProfileRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WineProfileList
 *
 * @Route("/les-profils", name="list_profiles")
 */
final class WineProfileList
{
    /** @var BreadcrumbRepository */
    protected $breadcrumbRepository;

    /** @var WineProfileRepository */
    protected $wineProfileRepository;

    public function __construct(
        BreadcrumbRepository $breadcrumbRepository,
        WineProfileRepository $wineProfileRepository
    ) {
        $this->breadcrumbRepository = $breadcrumbRepository;
        $this->wineProfileRepository = $wineProfileRepository;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $profiles = $this->wineProfileRepository->findAllOrderedByOrder();
        $breadcrumb = $this->breadcrumbRepository->findByPage('Profil de vin');

        $response = $responder(
            'wine_profile/list.html.twig',
            [
                'profiles' => $profiles,
                'breadcrumb' => $breadcrumb,
            ]
        );

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }
}
