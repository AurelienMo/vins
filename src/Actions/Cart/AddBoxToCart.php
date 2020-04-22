<?php

namespace App\Actions\Cart;

use App\Domain\Cart\Helpers\CartHelper;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Entity\BoxWine;
use App\Entity\Capacity;
use App\Repository\BoxWineRepository;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart/box/{id}", name="add_box_to_card", methods={"POST"})
 */
class AddBoxToCart
{
    /** @var BoxWineRepository */
    protected $boxRepository;

    /** @var CartHelper */
    protected $cartHelper;

    public function __construct(BoxWineRepository $boxRepository, CartHelper $cartHelper)
    {
        $this->boxRepository = $boxRepository;
        $this->cartHelper = $cartHelper;
    }


    public function __invoke(Request $request, JsonResponder $responder)
    {
        /** @var BoxWine $box */
        $box = $this->boxRepository->find($request->attributes->get('id'));
        $quantity = (int) json_decode($request->getContent(), true)['quantity'];

        if ($quantity <= 0) {
            return $responder(
                [
                    'code' => 400,
                    'type' => 'bad_request',
                    'message' => 'La quantité doit être supérieur à 0.'
                ]
            );
        }

        $wines = $box->getWines()->toArray();
        usort($wines, [$this, 'cmpStock']);

        foreach ($wines as $wine) {
            $totalStockAvailable = $this->getTotalStock($wine);

            if ($quantity > $totalStockAvailable) {
                $message = sprintf('Un des stocks produit est indisponible. %s box disponible', $totalStockAvailable);
                return $responder(
                    [
                        'code' => 400,
                        'type' => 'out_of_stock',
                        'message' => "<div class=\"out_of_stock alert alert-warning alert-dismissible fade show text-center\" role=\"alert\">
                        $message
                    </div>",
                    ]
                );
            }
        }

        $totalQty = $this->cartHelper->addBoxToCart($box, $quantity);

        return $responder(
            [
                'code' => 200,
                'qtyadd' => $totalQty,
            ]
        );
    }

    private function cmpStock(Capacity $a, Capacity $b)
    {
        return $a->getStock()->getQuantity() <=> $b->getStock()->getQuantity();
    }

    private function getTotalStock(Capacity $wine)
    {
        $productsVo = $this->cartHelper->getCartForCurrentUser()->getProducts();
        $productVo = array_filter($productsVo, function (ProductVO $vo) use ($wine) {
            return $vo->getCapacity()->getId() === $wine->getId();
        });
        $actualStock = $wine->getStock()->getQuantity();
        if (count($productVo) > 0) {
            $actualStock -= current($productVo)->getQuantity();
        }

        return $actualStock <= 0 ? 0 : $actualStock;
    }
}
