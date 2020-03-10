<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Domain\Cart\AddItemToCart\Forms\AddItemToCartType;
use App\Domain\Cart\AddItemToCart\Forms\ItemDTO;
use App\Domain\Cart\Helpers\CartHelper;
use App\Repository\ProductRepository;
use App\Responders\JsonResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/cart/wines/{id}/add", name="add_wine_to_card")
 */
class AddWineToCart
{
    /** @var ProductRepository */
    protected $wineRepository;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Environment */
    protected $templating;

    /** @var CartHelper */
    protected $cartHelper;

    public function __construct(
        ProductRepository $wineRepository,
        FormFactoryInterface $formFactory,
        Environment $templating,
        CartHelper $cartHelper
    ) {
        $this->wineRepository = $wineRepository;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->cartHelper = $cartHelper;
    }


    public function __invoke(Request $request, JsonResponder $responder)
    {
        $wine = $this->wineRepository->find($request->attributes->get('id'));
        $dto = ItemDTO::createFromWineEntity($wine, $this->cartHelper->getCartForCurrentUser());
        $form = $this->formFactory->create(AddItemToCartType::class, $dto)
                                  ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $totalQty = $this->cartHelper->addProductsToCart($form->getData());

            return $responder(
                [
                    'code' => Response::HTTP_CREATED,
                    'html' => '<div class="valid-add text-center">Panier mis à jour</span></div>',
                    'qtyadd' => $totalQty
                ]
            );
        }

        return $responder(
            [
                'code' => Response::HTTP_OK,
                'html' => $this->templating->render(
                    'cart/add_item_product.html.twig',
                    [
                        'form' => $form->createView(),
                        'dto' => $dto,
                    ]
                )
            ]
        );
    }
}
