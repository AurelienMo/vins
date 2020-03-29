<?php

declare(strict_types=1);

namespace App\Domain\Cart\ValueObject;

class StripeVO
{
    /** @var string */
    protected $customerStripe;

    /** @var string */
    protected $orderNumber;

    public function __construct(string $customerStripe, string $orderNumber)
    {
        $this->customerStripe = $customerStripe;
        $this->orderNumber = $orderNumber;
    }

    public function getCustomerStripe(): string
    {
        return $this->customerStripe;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }
}
