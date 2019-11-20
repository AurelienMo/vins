<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <aurelien.morvan@infostrates.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Admin\Subscribers;

use App\Entity\Capacity;
use App\Entity\Stock;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class CapacitySubscriber
 */
class CapacitySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'initStock',
        ];
    }

    public function initStock(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if ($entity instanceof Capacity) {
            $entity->setStock(new Stock());
        }
    }
}
