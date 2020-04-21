<?php

namespace App\Actions\Box;

use App\Domain\Cart\Helpers\CartHelper;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Entity\BoxWine;
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

    /** @var CartHelper */
    protected $cartHelper;

    public function __construct(BoxWineRepository $boxWineRepository, CartHelper $cartHelper)
    {
        $this->boxWineRepository = $boxWineRepository;
        $this->cartHelper = $cartHelper;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $cart = $this->cartHelper->getCartForCurrentUser();
        $boxs = $this->boxWineRepository->listAllActiveWithStock();
        /** @var BoxWine $box */
        foreach ($boxs as $index => $box) {
            foreach ($box->getWines() as $capacity) {
                $productVoInCart = array_filter($cart->getProducts(), function (ProductVO $vo) use ($capacity) {
                    return $vo->getCapacity()->getId() === $capacity->getId();
                });

                if (count($productVoInCart) > 0 && ($capacity->getStock()->getQuantity() - current($productVoInCart)->getQuantity()) <= 0) {
                    unset($boxs[$index]);
                }
            }
        }

        return $responder(
            'box/list.html.twig',
            [
                'boxs' => $boxs
            ]
        );
    }
}
