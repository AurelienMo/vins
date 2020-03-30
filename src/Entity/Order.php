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

use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Domain\Cart\ValueObject\StripeVO;
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
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\OrderProductLine",
     *     mappedBy="order",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=TRUE
     * )
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
     * @ORM\OneToOne(targetEntity="App\Entity\Delivery", cascade={"persist", "remove"}, mappedBy="order")
     * @ORM\JoinColumn(name="amo_delivery_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $delivery;

    /**
     * @var Customer|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="amo_customer_id", referencedColumnName="id")
     */
    protected $customer;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $customerStripeId;

    public function __construct(
        ?string $orderNumber = null,
        ?string $customerStripeId = null,
        ?Customer $customer = null,
        ?Delivery $delivery = null
    ) {
        $this->orderAt = new DateTime();
        $this->lines = new ArrayCollection();
        $this->orderNumber = $orderNumber;
        $this->delivery = $delivery instanceof Delivery ? $delivery : new Delivery();
        $this->customer = $customer instanceof Customer ? $customer : new Customer();
        $this->customerStripeId = $customerStripeId;
        parent::__construct();
    }

    public static function createFromPayment(CartVO $cart, StripeVO $stripeVo, Customer $customer, Delivery $delivery)
    {
        $order = new self($stripeVo->getOrderNumber(), $stripeVo->getCustomerStripe(), $customer, $delivery);
        /** @var ProductVO $product */
        foreach ($cart->getProducts() as $product) {
            $line = OrderProductLine::create($product);
            $order->addLine($line);
        }
        //TODO Add box line

        return $order;
    }

    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->customer->getFullName(),
            $this->orderAt->format('d/m/Y')
        );
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
        if (!$this->lines->contains($line)) {
            $this->lines->add($line);
            $line->setOrder($this);
        }

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
        $delivery->setOrder($this);
        $this->delivery = $delivery;
    }

    public function getStatus(): string
    {
        return $this->delivery->getStatus();
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        dump($this->customer);
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     */
    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function countBottle()
    {
        $bottles = $this->lines->filter(function (OrderProductLine $line) {
            return $line->getCapacityName() === 'Bouteille';
        });

        $cpt = 0;
        /** @var OrderProductLine $bottle */
        foreach ($bottles as $bottle) {
            $cpt += $bottle->getQuantity();
        }

        return $cpt;
    }

    public function countCubis()
    {
        $cubis = $this->lines->filter(function (OrderProductLine $line) {
            return $line->getCapacityName() === 'Cubis';
        });

        $cpt = 0;
        /** @var OrderProductLine $cubis */
        foreach ($cubis as $cubis) {
            $cpt += $cubis->getQuantity();
        }

        return $cpt;
    }

    public function getCustomerStripeId(): string
    {
        return $this->customerStripeId;
    }

    public function getTotalAmount()
    {
        $total = $this->delivery->getTypeDelivery() === 'basic' ? 4 : 6;
        /** @var OrderProductLine $line */
        foreach ($this->lines as $line) {
            $total += $line->getUnitPrice() * $line->getQuantity();
        }

        return round($total, 2).' €';
    }
}
