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
use App\Entity\Traits\TimeStampableTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Delivery
 *
 * @ORM\Table(name="amo_delivery")
 * @ORM\Entity()
 */
class Delivery extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    public const DELIVERY_IN_PROGRESS = 'Livraison en cours';
    public const DELIVERED_AT_RELAY_POINT = 'Livré en point relais';
    public const DELIVERED_AT_ADDRESS = 'Livré à l\'adresse';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=190)
     */
    protected $status;

    /**
     * @var DeliveryType|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\DeliveryType")
     * @ORM\JoinColumn(name="amo_delivery_type_id", referencedColumnName="id")
     */
    protected $deliveryType;

    /**
     * @var DeliveryPoint|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\DeliveryPoint")
     * @ORM\JoinColumn(name="amo_delivery_point_id", referencedColumnName="id", nullable=true)
     */
    protected $deliveryPoint;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $statusDate;

    /**
     * @var NicheOfDelivery|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\NicheOfDelivery", inversedBy="deliveries")
     * @ORM\JoinColumn(name="amo_niche_of_delivery_id", referencedColumnName="id", nullable=true)
     */
    protected $niche;

    /**
     * @var Order
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Order", cascade={"remove"}, inversedBy="delivery")
     * @ORM\JoinColumn(name="amo_order_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $order;

    public function __construct()
    {
        $this->status = self::DELIVERY_IN_PROGRESS;
        $this->statusDate = new DateTime();
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return DeliveryType|null
     */
    public function getDeliveryType(): ?DeliveryType
    {
        return $this->deliveryType;
    }

    /**
     * @param DeliveryType|null $deliveryType
     */
    public function setDeliveryType(?DeliveryType $deliveryType): void
    {
        $this->deliveryType = $deliveryType;
    }

    /**
     * @return DeliveryPoint|null
     */
    public function getDeliveryPoint(): ?DeliveryPoint
    {
        return $this->deliveryPoint;
    }

    /**
     * @param DeliveryPoint|null $deliveryPoint
     */
    public function setDeliveryPoint(?DeliveryPoint $deliveryPoint): void
    {
        $this->deliveryPoint = $deliveryPoint;
    }

    /**
     * @return DateTime
     */
    public function getStatusDate(): DateTime
    {
        return $this->statusDate;
    }

    /**
     * @param DateTime $statusDate
     */
    public function setStatusDate(DateTime $statusDate): void
    {
        $this->statusDate = $statusDate;
    }

    /**
     * @return NicheOfDelivery|null
     */
    public function getNiche(): ?NicheOfDelivery
    {
        return $this->niche;
    }

    /**
     * @param NicheOfDelivery|null $niche
     */
    public function setNiche(?NicheOfDelivery $niche): void
    {
        $this->niche = $niche;
    }

    /**
     * @return Order
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }
}
