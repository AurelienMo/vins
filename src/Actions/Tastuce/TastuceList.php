<?php

declare(strict_types=1);

namespace App\Actions\Tastuce;

use App\Repository\TastuceThemeRepository;
use App\Responders\ViewResponder;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tastuces", name="tastuces_list")
 */
class TastuceList
{
    /** @var TastuceThemeRepository */
    protected $tastuceThemeRepository;

    public function __construct(TastuceThemeRepository $tastuceThemeRepository)
    {
        $this->tastuceThemeRepository = $tastuceThemeRepository;
    }

    public function __invoke(ViewResponder $responder)
    {
        $themes = $this->tastuceThemeRepository->findAllOrderedByOrder();

        return $responder(
            'tastuces/list.html.twig',
            [
                'themes' => $themes,
            ]
        );
    }
}
