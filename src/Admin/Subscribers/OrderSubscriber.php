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

use App\Domain\Common\Helpers\BillGenerator;
use App\Domain\Common\Helpers\PromotionCalculate;
use App\Domain\Common\Helpers\StockUpdater;
use App\Entity\Order;
use App\Entity\OrderProductLine;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class OrderSubscriber
 */
class OrderSubscriber implements EventSubscriberInterface
{
    /** @var PromotionCalculate */
    protected $promotionCalculator;

    /** @var BillGenerator */
    protected $billGenerator;

    /**
     * OrderSubscriber constructor.
     *
     * @param PromotionCalculate $promotionCalculator
     * @param BillGenerator      $billGenerator
     */
    public function __construct(
        PromotionCalculate $promotionCalculator,
        BillGenerator $billGenerator
    ) {
        $this->promotionCalculator = $promotionCalculator;
        $this->billGenerator = $billGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'onPersist',
            EasyAdminEvents::PRE_UPDATE => 'onUpdate',
        ];
    }

    public function onPersist(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!$entity instanceof Order) {
            return;
        }

        if (is_null($entity->getBillNumber())) {
            $entity->setBillNumber($this->billGenerator->generateBillNumber($entity));
        }
        foreach ($entity->getLines() as $line) {
            $product = $line->getWine();
            $rate = $product->getTvaRate();
            $priceProductsLine = $this->promotionCalculator->calculatePricePromotion($line);
            $line->setTvaRate($rate);
            $line->setAmount($priceProductsLine);
            $line->setUpdatedAt(new DateTime());
            StockUpdater::updateStockAfterOrder($line->getWine(), $line->getQuantity());
        }
    }

    public function onUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!$entity instanceof Order) {
            return;
        }

        if (is_null($entity->getBillNumber())) {
            $entity->setBillNumber($this->billGenerator->generateBillNumber($entity));
        }

        foreach ($entity->getLines() as $line) {
            $isNew = is_null($line->getAmount());
            $product = $line->getWine();
            $rate = $product->getTvaRate();
            $priceProductsLine = $this->promotionCalculator->calculatePricePromotion($line);
            $line->setTvaRate($rate);
            $line->setAmount($priceProductsLine);
            $line->setUpdatedAt(new DateTime());
            if ($isNew) {
                StockUpdater::updateStockAfterOrder($line->getWine(), $line->getQuantity());
            }
        }
    }
}
