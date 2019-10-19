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

namespace App\Admin\Controller;

use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController as AdminController;
use App\Domain\Common\Helpers\BillGenerator;
use App\Domain\Common\Helpers\PromotionCalculate;
use App\Entity\Interfaces\Sluggable;
use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Stock;
use DateTime;
use ReflectionClass;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class EasyAdminController
 */
class EasyAdminController extends AdminController
{
    /** @var BillGenerator */
    protected $billGenerator;

    /** @var PromotionCalculate */
    protected $promotionCalculate;

    public function __construct(
        BillGenerator $billGenerator,
        PromotionCalculate $promotionCalculate
    ) {
        $this->billGenerator = $billGenerator;
        $this->promotionCalculate = $promotionCalculate;
    }

    public function persistEntity($entity)
    {
        $reflectClass = new ReflectionClass($entity);
        $propertyAccessor = new PropertyAccessor();
        if ($entity instanceof Sluggable) {
            foreach ($reflectClass->getProperties() as $prop) {
                switch ($prop->getName()) {
                    case 'name':
                        $entity->setSlug($propertyAccessor->getValue($entity, 'name'));
                        break;
                }
            }
        }
        if ($entity instanceof Product) {
            $entity->setStock(new Stock());
        }

        if ($entity instanceof Order) {
            $this->processOrder($entity);
        }

        parent::persistEntity($entity);
    }

    public function updateEntity($entity)
    {
        if ($entity instanceof Sluggable) {
            $reflectClass = new ReflectionClass($entity);
            $propertyAccessor = new PropertyAccessor();
            foreach ($reflectClass->getProperties() as $prop) {
                switch ($prop->getName()) {
                    case 'name':
                        $entity->setSlug($propertyAccessor->getValue($entity, 'name'));
                        break;
                }
            }
        }
        if ($entity instanceof UpdatableInterface) {
            $entity->setUpdatedAt(new DateTime());
        }
        if ($entity instanceof Order) {
            $this->processOrder($entity);
        }

        parent::updateEntity($entity);
    }

    private function processOrder(Order $entity)
    {
        if (is_null($entity->getBillNumber())) {
            $entity->setBillNumber($this->billGenerator->generateBillNumber($entity));
        }
        foreach ($entity->getLines() as $line) {
            //TODO Obtenir Taux TVA sur le produit
            $line->setTvaRate(0.0);
            $line->setAmount(
                $this->promotionCalculate->calculatePricePromotion($line->getWine()) * $line->getQuantity()
            );
            $line->setUpdatedAt(new DateTime());
        }
    }
}
