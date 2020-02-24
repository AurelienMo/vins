<?php

declare(strict_types=1);

namespace App\Actions\Wine;

use App\Repository\ProductRepository;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/wine/{id}", name="detail_wine")
 */
class DetailWine
{
    /** @var Environment */
    protected $templating;

    /** @var ProductRepository */
    protected $wineRepository;

    public function __construct(Environment $templating, ProductRepository $wineRepository)
    {
        $this->templating = $templating;
        $this->wineRepository = $wineRepository;
    }


    public function __invoke(Request $request, JsonResponder $responder)
    {
        $wine = $this->wineRepository->find($request->attributes->get('id'));

        return $responder(
            [
                'code' => Response::HTTP_OK,
                'html' => $this->templating->render('wines/detail.html.twig', ['wine' => $wine])
            ]
        );
    }
}
