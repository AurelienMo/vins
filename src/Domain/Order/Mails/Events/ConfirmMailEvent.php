<?php

declare(strict_types=1);

namespace App\Domain\Order\Mails\Events;

use App\Entity\Order;
use Symfony\Contracts\EventDispatcher\Event;

class ConfirmMailEvent extends Event
{
    /** @var Order */
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
