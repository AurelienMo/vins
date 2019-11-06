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
use App\Entity\Delivery;
use App\Entity\Order;
use App\Entity\OrderProductLine;
use App\Repository\OrderProductLineRepository;
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

    /** @var OrderProductLineRepository */
    protected $orderProductLineRepo;

    /**
     * OrderSubscriber constructor.
     *
     * @param PromotionCalculate         $promotionCalculator
     * @param BillGenerator              $billGenerator
     * @param OrderProductLineRepository $orderProductLineRepo
     */
    public function __construct(
        PromotionCalculate $promotionCalculator,
        BillGenerator $billGenerator,
        OrderProductLineRepository $orderProductLineRepo
    ) {
        $this->promotionCalculator = $promotionCalculator;
        $this->billGenerator = $billGenerator;
        $this->orderProductLineRepo = $orderProductLineRepo;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'onPersist',
            EasyAdminEvents::PRE_UPDATE => 'onUpdate',
            EasyAdminEvents::PRE_REMOVE => 'onPreRemove',
        ];
    }


    public function onPersist(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!$entity instanceof Order) {
            return;
        }

        $this->processDelivery($entity, 'add');

        if (is_null($entity->getBillNumber())) {
            $entity->setBillNumber($this->billGenerator->generateBillNumber($entity));
            $entity->getCustomer()->setRgpdAcceptedAt(new DateTime());
        }
        foreach ($entity->getLines() as $line) {
            $product = $line->getWine();
            $rate = $product->getTvaRate();
            $priceProductsLine = $this->promotionCalculator->calculatePricePromotion($line);
            $line->setTvaRate($rate);
            $line->setAmount($priceProductsLine);
            $line->setUpdatedAt(new DateTime());
            StockUpdater::updateStockAfterOrder($line->getWine(), -$line->getQuantity());
        }
    }

    public function onUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!$entity instanceof Order) {
            return;
        }
        $this->processDelivery($entity, 'update');

        foreach ($entity->getLines() as $line) {
            $qtyDiff = $this->isDifferentPreviously($line);
            StockUpdater::updateStockAfterOrder($line->getWine(), $qtyDiff);
            $product = $line->getWine();
            $rate = $product->getTvaRate();
            $priceProductsLine = $this->promotionCalculator->calculatePricePromotion($line);
            $line->setTvaRate($rate);
            $line->setAmount($priceProductsLine);
            $line->setUpdatedAt(new DateTime());
        }
    }

    public function onPreRemove(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!$entity instanceof Order) {
            return;
        }

//        $delivery = $entity->getDelivery();
//        $entity->getDelivery()->setOrder(null);
//        $this->orderProductLineRepo->remove()
//        $this->orderProductLineRepo->flush($);

        foreach ($entity->getLines() as $line) {
            StockUpdater::updateStockAfterOrder($line->getWine(), $line->getQuantity());
        }
    }

    private function isDifferentPreviously(OrderProductLine $line)
    {
        $data = $this->orderProductLineRepo->getEm()->getUnitOfWork()->getOriginalEntityData($line);

        if (empty($data)) {
            return -$line->getQuantity();
        }

        return $data['quantity'] - $line->getQuantity();
    }

    private function processDelivery(Order $entity, string $type)
    {
        $delivery = $entity->getDelivery();
        switch ($delivery->getDeliveryType()) {
            case "A l'adresse":
                if (!is_null($delivery->getDeliveryPoint())) {
                    $delivery->getNiche()->setNumberNiche($delivery->getNiche()->getNumberNiche() - 1);
                    $delivery->setDeliveryPoint(null);
                }
                break;
            case "Point relais":
                if (!is_null($delivery->getNiche())) {
                    $delivery->getNiche()->setNumberNiche($delivery->getNiche()->getNumberNiche() + 1);
                    $delivery->setNiche(null);
                }
                break;
        }
        $delivery->setOrder($entity);
    }
}
