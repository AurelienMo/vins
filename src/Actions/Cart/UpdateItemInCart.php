<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Domain\Cart\Helpers\CartHelper;
use App\Domain\Cart\LiveUpdateCart\InputItemObject;
use App\Domain\Cart\ValueObject\CartVO;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/cart/items/update", name="update_cart", methods={"POST"})
 */
class UpdateItemInCart
{
    /** @var SerializerInterface */
    protected $serializer;

    /** @var SessionInterface */
    protected $session;

    /** @var CartHelper */
    protected $cartHelper;

    public function __construct(
        SerializerInterface $serializer,
        SessionInterface $session,
        CartHelper $cartHelper
    ) {
        $this->serializer = $serializer;
        $this->session = $session;
        $this->cartHelper = $cartHelper;
    }

    public function __invoke(Request $request, JsonResponder $responder)
    {
        $input = $this->serializer->deserialize($request->getContent(), InputItemObject::class, 'json');
        $response = $this->cartHelper->updateCurrentCart($input);

        return $responder($response);
    }
}
