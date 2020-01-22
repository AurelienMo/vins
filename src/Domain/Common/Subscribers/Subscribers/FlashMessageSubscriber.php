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

namespace App\Domain\Common\Subscribers\Subscribers;

use App\Domain\Common\Subscribers\Events\FlashMessageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class FlashMessageSubscriber
 */
final class FlashMessageSubscriber implements EventSubscriberInterface
{
    /** @var SessionInterface */
    protected $session;

    /**
     * FlashMessageSubscriber constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(
        SessionInterface $session
    ) {
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            FlashMessageEvent::class => 'addFlash',
        ];
    }

    public function addFlash(FlashMessageEvent $event)
    {
        $this->session->getFlashBag()->add($event->getType(), $event->getMessage());
    }
}
