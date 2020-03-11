<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Entity\WineDomain;
use App\Responders\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mon-panier", name="cart_checkout")
 */
class CartCheckout
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

    public function __invoke(ViewResponder $responder)
    {
        $cart = $this->session->has('cart') ? $this->session->get('cart') : null;
        /** @var ProductVO $product */
        if ($cart instanceof CartVO) {
            foreach ($cart->getProducts() as $product) {
                $domain = $this->entityManager->getRepository(WineDomain::class)->find($product->getDomain()->getId());
                $product->setDomain($domain);
            }
        }

        return $responder(
           'cart/checkout.html.twig',
            [
                'cart' => $cart,
            ]
        );
    }
}
