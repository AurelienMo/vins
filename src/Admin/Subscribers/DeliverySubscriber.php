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

use App\Admin\Delivery\Events\ConfirmDeliveryEvent;
use App\Entity\BoxWine;
use App\Entity\Delivery;
use App\Repository\BoxWineRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class DeliverySubscriber implements EventSubscriberInterface
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

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

        $id = $entity->getId();
        $sql = "SELECT status FROM amo_delivery WHERE id = '$id'";
        $stmt = $this->entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        if ($entity->getStatus() === Delivery::DELIVERY_AT_VOISIN && $entity->getStatus() !== $stmt->fetch()['status']) {
            $this->eventDispatcher->dispatch(new ConfirmDeliveryEvent(Delivery::DELIVERY_AT_VOISIN, $entity));
            $entity->setStatusDate(new \DateTime());
        }
        if ($entity->getStatus() === Delivery::DELIVERED_AT_ADDRESS && $entity->getStatus() !== $stmt->fetch()['status']) {
            $this->eventDispatcher->dispatch(new ConfirmDeliveryEvent(Delivery::DELIVERED_AT_ADDRESS, $entity));
            $entity->setStatusDate(new \DateTime());
        }
        if ($entity->getStatus() === Delivery::DELIVERY_MISS && $entity->getStatus() !== $stmt->fetch()['status']) {
            $this->eventDispatcher->dispatch(new ConfirmDeliveryEvent(Delivery::DELIVERY_MISS, $entity));
            $entity->setStatusDate(new \DateTime());
        }
    }
}
