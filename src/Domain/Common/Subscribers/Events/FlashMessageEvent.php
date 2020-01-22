<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Common\Subscribers\Events;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class FlashMessageEvent
 */
class FlashMessageEvent extends Event
{
    /** @var string */
    protected $type;

    /** @var string */
    protected $message;

    /**
     * FlashMessageEvent constructor.
     *
     * @param string $type
     * @param string $message
     */
    public function __construct(
        string $type,
        string $message
    ) {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
