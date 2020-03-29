<?php

declare(strict_types=1);

namespace App\Domain\Order\Mails\Events;

use App\Entity\Order;
use Symfony\Contracts\EventDispatcher\Event;

class ConfirmMailEvent extends Event
{
    /** @var Order */
    protected $order;

    /** @var string */
    protected $bill;

    public function __construct(Order $order, string $bill)
    {
        $this->order = $order;
        $this->bill = $bill;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getBill(): string
    {
        return $this->bill;
    }
}
