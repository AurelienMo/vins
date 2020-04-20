<?php

namespace App\Actions\Box;

use App\Repository\BoxWineRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListBox
 *
 * @Route("/box-du-moment", name="list_box")
 */
class ListBox
{
    /** @var BoxWineRepository */
    protected $boxWineRepository;

    /**
     * ListBox constructor.
     * @param BoxWineRepository $boxWineRepository
     */
    public function __construct(BoxWineRepository $boxWineRepository)
    {
        $this->boxWineRepository = $boxWineRepository;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $boxs = $this->boxWineRepository->listAllActiveWithStock();

        return $responder(
            'box/list.html.twig',
            [
                'boxs' => $boxs
            ]
        );
    }
}
