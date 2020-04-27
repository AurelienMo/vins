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

use App\Entity\BoxWine;
use App\Entity\Delivery;
use App\Repository\BoxWineRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class DeliverySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_UPDATE => 'onUpdate',
        ];
    }

    public function onUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if (!$entity instanceof Delivery) {
            return;
        }

        if ($entity->getStatus() === Delivery::DELIVERY_AT_VOISIN) {
            //TODO Send mail to confirm delivery to voisin
        }
        if ($entity->getStatus() === Delivery::DELIVERED_AT_ADDRESS) {
            //TODO Send mail to confirm delivery
        }
    }
}
