<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Domain\Cart\Helpers\CartHelper;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/cart/items/{id}", name="remove_item_cart", methods={"DELETE"})
 */
class RemoveItemInCart
{
    /** @var CartHelper */
    protected $cartHelper;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    public function __construct(CartHelper $cartHelper, UrlGeneratorInterface $urlGenerator)
    {
        $this->cartHelper = $cartHelper;
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(Request $request, JsonResponder $responder)
    {
        $id = $request->attributes->get('id');
        $type = $request->query->get('type');
        $this->cartHelper->removeCapacityFromCart($id, $type);

        return $responder(['url' => $this->urlGenerator->generate('cart_checkout')]);
    }
}
