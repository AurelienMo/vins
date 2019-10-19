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

namespace App\Domain\Common\Helpers;

use App\Entity\Order;
use App\Repository\OrderRepository;

/**
 * Class BillGenerator
 */
class BillGenerator
{
    /** @var OrderRepository */
    protected $orderRepo;

    /**
     * BillGenerator constructor.
     *
     * @param OrderRepository $orderRepo
     */
    public function __construct(
        OrderRepository $orderRepo
    ) {
        $this->orderRepo = $orderRepo;
    }

    public function generateBillNumber(Order $order): string
    {
        $orders = $this->orderRepo->findAll();
        $resultsExploded = [];
        $billNumber = 1;
        if (count($orders) > 0) {
            foreach ($orders as $order) {
                $resultsExploded[] = explode(
                                         '_',
                                         $order->getBillNumber()
                                     )[3];
            }
            rsort($resultsExploded, SORT_NUMERIC);
            $current = current($resultsExploded);
            $current++;
            $billNumber = $current;
        }


        return sprintf(
            '%s_%s',
            $order->getOrderAt()->format('Y_m_d'),
            str_pad((string) $billNumber, 4, '0', STR_PAD_LEFT)
        );
    }
}
