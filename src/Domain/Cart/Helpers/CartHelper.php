<?php

declare(strict_types=1);

namespace App\Domain\Cart\Helpers;

use App\Domain\Cart\AddItemToCart\Forms\ElementDTO;
use App\Domain\Cart\AddItemToCart\Forms\ItemDTO;
use App\Domain\Cart\LiveUpdateCart\InputItemObject;
use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Entity\WineDomain;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartHelper
{
    /** @var SessionInterface */
    protected $session;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }


    public function addProductsToCart(ItemDTO $dto): int
    {
        $cart = $this->getCartForCurrentUser();
        $domain = $this->entityManager->getRepository(WineDomain::class)->find($dto->getWine()->getDomain()->getId());
        $totalQtyAdded = 0;
        /** @var ElementDTO $element */
        foreach ($dto->getElements() as $element) {
            if ($element->getQuantity() > 0) {
                $productVO = new ProductVO($dto->getWine(), $domain, $element->getCapacity(), $element->getQuantity());
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

    /**
     * @param InputItemObject[] $itemsUpdate
     */
    public function updateCurrentCart(array $itemsUpdate)
    {
        /** @var CartVO $cart */
        $cart = $this->getCartForCurrentUser();
        $capacitiesInCart = $cart->getProducts();
        foreach ($itemsUpdate as $item) {
            $productToUpdate = current(array_filter($capacitiesInCart, function (ProductVO $vo) use ($item) {
                return $item->getId() === $vo->getCapacity()->getId();
            }));
            if ($item->getNew() === 0) {
                $cart->removeProduct($productToUpdate);

                return;
            }
            if ($item->getNew() < 0) {
                return;
            }
            if ($productToUpdate->getQuantity() !== $item->getNew()) {
                $productToUpdate->updateQuantity($item->getNew());
            }
        }
    }

    public function removeCapacityFromCart(string $id)
    {
        $cart = $this->getCartForCurrentUser();
        $capacitiesProduct = $cart->getProducts();
        $productVoToRemove = current(array_filter($capacitiesProduct, function (ProductVO $vo) use ($id) {
            return $vo->getCapacity()->getId() === $id;
        }));

        $cart->removeProduct($productVoToRemove);
    }
}
