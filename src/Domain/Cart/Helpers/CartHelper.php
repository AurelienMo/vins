<?php

declare(strict_types=1);

namespace App\Domain\Cart\Helpers;

use App\Domain\Cart\AddItemToCart\Forms\ElementDTO;
use App\Domain\Cart\AddItemToCart\Forms\ItemDTO;
use App\Domain\Cart\LiveUpdateCart\InputItemObject;
use App\Domain\Cart\ValueObject\BoxVO;
use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Domain\Common\Helpers\PromotionCalculate;
use App\Entity\BoxWine;
use App\Entity\Capacity;
use App\Entity\Interfaces\OpinionElementInterface;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\WineDomain;
use App\Repository\PromotionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartHelper
{
    /** @var SessionInterface */
    protected $session;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var PromotionRepository */
    protected $promotionRepository;

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $entityManager,
        PromotionRepository $promotionRepository
    ) {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->promotionRepository = $promotionRepository;
    }

    public function addProductsToCart(ItemDTO $dto): int
    {
        $cart = $this->getCartForCurrentUser();
        $domain = $this->entityManager->getRepository(WineDomain::class)->find($dto->getWine()->getDomain()->getId());
        $totalQtyAdded = 0;
        /** @var ElementDTO $element */
        foreach ($dto->getElements() as $element) {
            if ($element->getQuantity() > 0) {
                $promotion = $this->promotionRepository->findActivePromoByProduct($dto->getWine());
                $pricePromo = null;
                if ($promotion instanceof Promotion) {
                    $pricePromo = PromotionCalculate::calcultePromoForProduct($element->getCapacity(), $promotion);
                }

                $productVO = new ProductVO(
                    $dto->getWine(),
                    $domain,
                    $element->getCapacity(),
                    $element->getQuantity(),
                    $element->getCapacity()->getUnitPrice(),
                    $pricePromo
                );
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

    public function removeCapacityFromCart(string $id, string $type)
    {
        $cart = $this->getCartForCurrentUser();
        $capacitiesProduct = $cart->getProducts();
        $boxs = $cart->getBoxs();
        switch ($type) {
            case 'box':
                $boxtoRemove = current(array_filter($boxs, function (BoxVO $vo) use ($id) {
                    return $vo->getBox()->getId() === $id;
                }));
                $cart->removeBox($boxtoRemove);
                break;
            case 'product':
                $productVoToRemove = current(array_filter($capacitiesProduct, function (ProductVO $vo) use ($id) {
                    return $vo->getCapacity()->getId() === $id;
                }));
                $cart->removeProduct($productVoToRemove);
                break;
        }
    }

    public function addBoxToCart(BoxWine $box, int $quantity)
    {
        $cart = $this->getCartForCurrentUser();

        $boxVo = new BoxVO($box, $quantity, $box->getPrice());
        $this->checkAndCleanBoxExist($cart, $boxVo);
        $cart->addBox($boxVo);

        $this->saveCartIntoSession($cart);

        return $cart->countElementsInCart();
    }

    private function checkAndCleanBoxExist(CartVO $cart, BoxVO $boxVo)
    {
        $boxvo = array_filter($cart->getBoxs(), function (BoxVO $vo) use ($boxVo) {
            return $vo->getBox()->getId() === $boxVo->getBox()->getId();
        });

        if (count($boxvo) > 0) {
            $cart->removeBox(current($boxvo));
        }
    }
}
