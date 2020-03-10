<?php

declare(strict_types=1);

namespace App\Domain\Cart\Helpers;

use App\Domain\Cart\AddItemToCart\Forms\ElementDTO;
use App\Domain\Cart\AddItemToCart\Forms\ItemDTO;
use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\ProductVO;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartHelper
{
    /** @var SessionInterface */
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    public function addProductsToCart(ItemDTO $dto): int
    {
        $cart = $this->getCartForCurrentUser();
        $totalQtyAdded = 0;
        /** @var ElementDTO $element */
        foreach ($dto->getElements() as $element) {
            if ($element->getQuantity() > 0) {
                $productVO = new ProductVO($dto->getWine(), $element->getCapacity(), $element->getQuantity());
                $this->checkAndCleanExist($cart, $element);
                $cart->addProduct($productVO);
                $totalQtyAdded += $productVO->getQuantity();
            } else {
                $this->checkAndCleanExist($cart, $element);
            }
        }
        $this->saveCartIntoSession($cart);

        return $cart->countElementsInCart();
    }

    public function getCartForCurrentUser(): CartVO
    {
        return $this->session->has('cart') ? $this->session->get('cart') : new CartVO();
    }

    private function saveCartIntoSession(CartVO $cartVo): void
    {
        $this->session->set('cart', $cartVo);
    }

    private function checkAndCleanExist(CartVO $cart, ElementDTO $element): void
    {
        $productsVoExist = array_filter($cart->getProducts(), function (ProductVO $vo) use ($element) {
            return $vo->getCapacity()->getId() === $element->getCapacity()->getId();
        });
        if (count($productsVoExist) > 0) {
            $cart->removeProduct(current($productsVoExist));
        }
    }
}
