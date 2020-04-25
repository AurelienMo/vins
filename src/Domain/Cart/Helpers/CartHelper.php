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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CartHelper
{
    /** @var SessionInterface */
    protected $session;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var PromotionRepository */
    protected $promotionRepository;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $entityManager,
        PromotionRepository $promotionRepository,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->promotionRepository = $promotionRepository;
        $this->urlGenerator = $urlGenerator;
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
     * @param InputItemObject $input
     */
    public function updateCurrentCart(InputItemObject $input)
    {
        /** @var CartVO $cart */
        $cart = $this->getCartForCurrentUser();
        $productsInCart = $cart->getProducts();
        $boxInCart = $cart->getBoxs();
        $urlRedirect = $this->urlGenerator->generate('cart_checkout');

        $response = [
            'code' => null,
            'url' => $urlRedirect,
            'code_type' => null,
            'available_stock' => null
        ];

        switch ($input->getType()) {
            case 'product':
                /** @var ProductVO $productToUpdate */
                $productToUpdate = current(array_filter($productsInCart, function (ProductVO $vo) use ($input) {
                    return $input->getId() === $vo->getCapacity()->getId();
                }));
                if ($input->getNew() === 0) {
                    $cart->removeProduct($productToUpdate);
                    $response['code'] = 200;
                    break;
                } else {
                    $actualStock = $productToUpdate->getCapacity()->getStock()->getQuantity();
                    $productInBox = array_filter($boxInCart, function (BoxVO $vo) use ($productToUpdate) {
                        return $vo->getBox()->getWines()->contains($productToUpdate->getCapacity());
                    });
                    $totalInBox = count($productInBox) > 0 ? 1 : 0;
                    if (($actualStock - $totalInBox - $input->getNew()) < 0) {
                        $response['code'] = 400;
                        $response['code_type'] = 'no_stock';
                        $response['available_stock'] = $actualStock - $totalInBox;
                    } else {
                        $response['code'] = 200;
                        $productToUpdate->updateQuantity($input->getNew());
                    }
                }
                break;
            case 'box':
                /** @var BoxVO $boxToUpdate */
                $boxToUpdate = current(array_filter($boxInCart, function (BoxVO $vo) use ($input) {
                    return $input->getId() === $vo->getBox()->getId();
                }));
                if ($input->getNew() === 0) {
                    $cart->removeBox($boxToUpdate);
                    $response['code'] = 200;
                } else {
                    $response['available_stock'] = null;
                    $response['code'] = 200;
                    foreach ($boxToUpdate->getBox()->getWines() as $wine) {
                        $actualStock = $wine->getStock()->getQuantity();
                        $productInCart = array_filter($productsInCart, function (ProductVO $vo) use ($wine) {
                            return $vo->getProduct()->getId() === $wine->getWine()->getId();
                        });
                        $stockAvailable = $actualStock;
                        if (count($productInCart) > 0) {
                            $stockAvailable -= current($productInCart)->getQuantity();
                        }
                        if (($stockAvailable - $input->getNew()) < 0) {
                            $response['code'] = 400;
                            $response['code_type'] = 'no_stock';
                            if (is_null($response['available_stock'])) {
                                $response['available_stock'] = $stockAvailable;
                            }
                            if ($response['available_stock'] > $stockAvailable) {
                                $response['available_stock'] = $stockAvailable;
                            }
                        }
                    }
                    if ($response['code'] === 200) {
                        $boxToUpdate->updateQuantity($input->getNew());
                    }
                }
                break;
        }

        return $response;
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
