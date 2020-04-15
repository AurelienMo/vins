<?php

declare(strict_types=1);

namespace App\Admin\Subscribers;

use App\Entity\Stock;
use App\Entity\StockEntry;
use App\Repository\StockEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class StockSubscriber implements EventSubscriberInterface
{
    /** @var StockEntryRepository */
    protected $stockEntryRepository;

    public function __construct(
        StockEntryRepository $stockEntryRepository
    ) {
        $this->stockEntryRepository = $stockEntryRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'onUpdateStock',
            EasyAdminEvents::PRE_UPDATE => 'onUpdateStock',
        ];
    }

    public function onUpdateStock(GenericEvent $event)
    {

        $subject = $event->getSubject();

        if (!$subject instanceof Stock) {
            return;
        }

        $listIdsStockEntries = array_map(function (StockEntry $entry) {
            return $entry->getId();
        }, $subject->getStockEntries()->toArray());

        $listExist = $this->stockEntryRepository->findByIds($listIdsStockEntries);

        foreach ($subject->getStockEntries() as $stockEntry) {
            $inExist = array_filter($listExist, function ($exist) use ($stockEntry) {
                return $exist['id'] === $stockEntry->getId();
            });
            $value = $stockEntry->getQuantity();
            if (count($inExist) > 0) {
                $current = current($inExist);
                $value = $stockEntry->getQuantity() - $current['quantity'];
            }

            $subject->updateStockAfterUpdate($value, $stockEntry->getTypeEntry());
        }
    }
}
