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

use App\Entity\Product;
use DateTime;

/**
 * Class StockUpdater
 */
class StockUpdater
{
    public static function updateStockAfterOrder(Product $product, int $quantity): void
    {
        $stock = $product->getStock();
        $stock->updateQuantityAfterOrder($quantity);
        $stock->setUpdatedAt(new DateTime());
    }
}
