<?php

declare(strict_types=1);

namespace App\Domain\Cart\Helpers;

use App\Domain\Cart\Delivery\Forms\DeliveryDTO;
use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\StripeVO;
use App\Entity\Order;
use Cassandra\Custom;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\CardException;
use Stripe\Stripe;

class StripeHelper
{
    /** @var CartHelper */
    protected $cartHelper;

    /** @var string */
    protected $apiPrivateKeyStripe;

    public function __construct(
        CartHelper $cartHelper,
        string $apiPrivateKeyStripe
    ) {
        $this->cartHelper = $cartHelper;
        $this->apiPrivateKeyStripe = $apiPrivateKeyStripe;
    }


    public function createChargeAndPayment(array $requestAttributes)
    {
        $cart = $this->cartHelper->getCartForCurrentUser();
        Stripe::setApiKey($this->apiPrivateKeyStripe);
        $customer = $this->getOrCreateCustomer($cart->getDeliveryInformation());
        $charge = $this->createCharge(
            $cart,
            $customer,
            $requestAttributes['stripeToken']
        );

        return new StripeVO($customer, $charge);
    }

    private function getOrCreateCustomer(DeliveryDTO $dto)
    {
        $iteratorCustomers = Customer::all()->getIterator();
        $existCustomer = array_filter(iterator_to_array($iteratorCustomers), function (Customer $customer) use ($dto) {
            return $customer->email === $dto->getEmail();
        });

        $customer = current($existCustomer) instanceof Customer ?
            current($existCustomer) :
            Customer::create(
                [
                    'email' => $dto->getEmail(),
                    'name' => sprintf('%s %s', $dto->getFirstname(), $dto->getName()),
                    'address' => [
                        'line1' => $dto->getAddress(),
                        'postal_code' => $dto->getZipCode(),
                        'city' => $dto->getCity(),
                    ],
                    'phone' => $dto->getPhoneNumber(),
                ]
            );

        return $customer->id;
    }

    private function createCharge(CartVO $cart, string $customer, string $paymentToken)
    {
        $charge = Charge::create(
            [
                'amount' => number_format($cart->getTotalPriceWithDelivery(), 2) * 100,
                'currency' => 'eur',
                'source' => $paymentToken,
            ]
        );

        return $charge->id;
    }
}
