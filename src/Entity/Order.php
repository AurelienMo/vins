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

use App\Domain\Common\Helpers\UuidGenerator;
use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 *
 * @ORM\Table(name="amo_order")
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime")
     */
    protected $orderAt;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $billNumber;

    /**
     * @var OrderProductLine[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProductLine", mappedBy="order", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     */
    protected $lines;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $orderNumber;

    /**
     * @var Delivery|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Delivery", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="amo_delivery_id", referencedColumnName="id", nullable=true)
     */
    protected $delivery;

    public function __construct()
    {
        $this->orderAt = new DateTime();
        $this->lines = new ArrayCollection();
        $this->orderNumber = UuidGenerator::generate();
        $this->delivery = new Delivery();
        parent::__construct();
    }

    /**
     * @return DateTime|null
     */
    public function getOrderAt(): ?DateTime
    {
        return $this->orderAt;
    }

    /**
     * @param DateTime|null $orderAt
     */
    public function setOrderAt(?DateTime $orderAt): void
    {
        $this->orderAt = $orderAt;
    }

    /**
     * @return string|null
     */
    public function getBillNumber(): ?string
    {
        return $this->billNumber;
    }

    /**
     * @param string|null $billNumber
     */
    public function setBillNumber(?string $billNumber): void
    {
        $this->billNumber = $billNumber;
    }

    /**
     * @return OrderProductLine[]|Collection
     */
    public function getLines()
    {
        return $this->lines;
    }

    public function addLine(OrderProductLine $line): Order
    {
        $this->lines->add($line);
        $line->setOrder($this);

        return $this;
    }

    public function removeLine(OrderProductLine $line): void
    {
        $this->lines->removeElement($line);
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function countProducts(): int
    {
        $cpt = 0;
        foreach ($this->lines as $line) {
            $cpt += $line->getQuantity();
        }

        return $cpt;
    }

    public function countAmountOrder()
    {
        $amount = 0;
        foreach ($this->lines as $line) {
            $amount += $line->getTvaRate() > 0 ? $line->getTvaRate() * $line->getAmount() : $line->getAmount();
        }

        return sprintf('%s €', $amount);
    }

    /**
     * @return Delivery|null
     */
    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    /**
     * @param Delivery|null $delivery
     */
    public function setDelivery(?Delivery $delivery): void
    {
        $this->delivery = $delivery;
    }

    public function getStatus(): string
    {
        return $this->delivery->getStatus();
    }
}
