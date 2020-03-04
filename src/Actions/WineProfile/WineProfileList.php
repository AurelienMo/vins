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

use App\Domain\WineProfile\Resolver;
use App\Entity\VineProfile;
use App\Repository\BreadcrumbRepository;
use App\Responders\ViewResponder;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WineProfileList
 *
 * @Route("/les-profils", name="list_profiles")
 */
final class WineProfileList
{
    /** @var Resolver */
    protected $resolver;

    /** @var BreadcrumbRepository */
    protected $breadcrumbRepository;

    /**
     * WineProfileList constructor.
     *
     * @param Resolver $resolver
     */
    public function __construct(
        Resolver $resolver,
        BreadcrumbRepository $breadcrumbRepository
    ) {
        $this->resolver = $resolver;
        $this->breadcrumbRepository = $breadcrumbRepository;
    }

    public function __invoke(ViewResponder $responder)
    {
        $profiles = $this->resolver->getListWineProfiles();
        $breadcrumb = $this->breadcrumbRepository->findByPage('Profil de vin');

        return $responder(
            'wine_profile/list.html.twig',
            [
                'profiles' => $profiles,
                'breadcrumb' => $breadcrumb,
            ]
        );
    }
}
