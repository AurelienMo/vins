<?php

declare(strict_types=1);

namespace App\Actions\Wine;

use App\Repository\ProductRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/les-vins", name="wine_list")
 */
class WineList
{
    /** @var ProductRepository */
    protected $wineRepository;

    public function __construct(
        ProductRepository $wineRepository
    ) {
        $this->wineRepository = $wineRepository;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $wines = $this->wineRepository->findAll();

        return $responder(
            'wines/list.html.twig',
            [
                'wines' => $wines,
            ]
        );
    }
}
