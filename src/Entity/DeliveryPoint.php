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

use App\Entity\Embedded\Address;
use App\Entity\Interfaces\Sluggable;
use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DeliveryPoint
 *
 * @ORM\Table(name="amo_delivery_point")
 * @ORM\Entity()
 */
class DeliveryPoint extends AbstractEntity implements UpdatableInterface, Sluggable
{
    use SlugTrait;
    use TimeStampableTrait;
    use NameTrait;

    /**
     * @var Address
     *
     * @ORM\Embedded(class="App\Entity\Embedded\Address")
     */
    protected $address;

    public function __construct()
    {
        $this->address = new Address();
        parent::__construct();
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }
}
