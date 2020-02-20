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

use App\Domain\Common\Helpers\SlugifyHelper;
use App\Entity\Interfaces\Sluggable;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class SlugSubscriber
 */
class SlugSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'defineSlug',
            EasyAdminEvents::PRE_UPDATE => 'defineSlug',
        ];
    }

    public function defineSlug(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if (!$entity instanceof Sluggable || is_null($entity->getName())) {
            return;
        }

        $slug = SlugifyHelper::slugify($entity->getName());
        $entity->setSlug($slug);

        $event['entity'] = $entity;
    }
}
