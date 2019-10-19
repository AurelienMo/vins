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

namespace App\Entity;

use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DeliveryType
 *
 * @ORM\Table(name="amo_delivery_type")
 * @ORM\Entity()
 */
class DeliveryType extends AbstractEntity implements UpdatableInterface
{
    use NameTrait;
    use TimeStampableTrait;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float")
     */
    protected $price;

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }
}
