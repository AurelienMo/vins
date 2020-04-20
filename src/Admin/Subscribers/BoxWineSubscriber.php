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
use App\Repository\BoxWineRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class BoxWineSubscriber implements EventSubscriberInterface
{
    /** @var BoxWineRepository */
    protected $boxWineRepo;

    /**
     * BoxWineSubscriber constructor.
     *
     * @param BoxWineRepository $boxWineRepo
     */
    public function __construct(
        BoxWineRepository $boxWineRepo
    ) {
        $this->boxWineRepo = $boxWineRepo;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'onUpdate',
            EasyAdminEvents::PRE_UPDATE => 'onUpdate',
        ];
    }

    public function onUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if (!$entity instanceof BoxWine) {
            return;
        }
    }
}
