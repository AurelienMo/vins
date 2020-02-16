<?php

declare(strict_types=1);

namespace App\Admin\Subscribers;

use App\Entity\SliderHome;
use App\Repository\SliderHomeRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class SliderHomeSubscriber implements EventSubscriberInterface
{
    /** @var SliderHomeRepository */
    protected $sliderHomeRepository;

    public function __construct(SliderHomeRepository $sliderHomeRepository)
    {
        $this->sliderHomeRepository = $sliderHomeRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'onPrePersist',
        ];
    }

    public function onPrePersist(GenericEvent $event)
    {
        $subject = $event->getSubject();
        if (!$subject instanceof SliderHome) {
            return;
        }
        $highestOrder = $this->sliderHomeRepository->selectHighestOrderNumber();
        $subject->setOrder(is_null($highestOrder) ? 1 : $highestOrder['order'] + 1);
    }
}
