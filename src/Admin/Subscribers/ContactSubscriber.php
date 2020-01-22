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

namespace App\Admin\Subscribers;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class ContactSubscriber
 */
final class ContactSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_UPDATE => 'onPreupdate',
        ];
    }

    public function onPreUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!$entity instanceof Contact) {
            return;
        }

        if (is_null($entity->getAnwseredOn())) {
            $entity->answer();
        }
    }
}
