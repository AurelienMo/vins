<?php

declare(strict_types=1);

namespace App\Actions\Common;

use App\Repository\BreadcrumbRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/breadcrumb/{type}", name="breadcrumb")
 */
class Breadcrumb
{
    /** @var BreadcrumbRepository */
    protected $breadcrumbRepository;

    public function __construct(BreadcrumbRepository $breadcrumbRepository)
    {
        $this->breadcrumbRepository = $breadcrumbRepository;
    }


    public function __invoke(Request $request, ViewResponder $responder)
    {
        $breadcrumb = $this->breadcrumbRepository->findByPage($request->attributes->get('type'));

        return $responder(
            'parts/_breadcrumb.html.twig',
            [
                'breadcrumb' => $breadcrumb,
            ]
        );
    }
}
