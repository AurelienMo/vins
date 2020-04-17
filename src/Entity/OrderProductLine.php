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

use App\Domain\Cart\ValueObject\ProductVO;
use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderProductLine
 *
 * @ORM\Table(name="amo_order_product_line")
 * @ORM\Entity(repositoryClass="App\Repository\OrderProductLineRepository")
 */
class OrderProductLine extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $vintageName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $year;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $domain;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $appellation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $capacityName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $litrage;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $unitPrice;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $pricePromo;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="lines")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    public function __construct(
        string $vintageName,
        string $year,
        string $domain,
        string $appellation,
        string $capacityName,
        string $litrage,
        float $unitPrice,
        int $quantity,
        ?float $pricePromo = null
    ) {
        $this->vintageName = $vintageName;
        $this->year = $year;
        $this->domain = $domain;
        $this->appellation = $appellation;
        $this->capacityName = $capacityName;
        $this->litrage = $litrage;
        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
        $this->pricePromo = $pricePromo;
        parent::__construct();
    }

    public function getVintageName(): string
    {
        return $this->vintageName;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getAppellation(): string
    {
        return $this->appellation;
    }

    public function getCapacityName(): string
    {
        return $this->capacityName;
    }

    public function getLitrage(): string
    {
        return $this->litrage;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getPricePromo(): ?float
    {
        return $this->pricePromo;
    }

    public static function create(ProductVO $vo)
    {
        return new self(
            $vo->getProduct()->getVintageName(),
            $vo->getProduct()->getYear(),
            $vo->getDomain()->getName(),
            $vo->getProduct()->getAppellation(),
            $vo->getCapacity()->getType(),
            $vo->getCapacity()->getQuantity() . 'L',
            $vo->getUnitPrice(),
            $vo->getQuantity(),
            $vo->getPricePromo()
        );
    }

    public function __toString()
    {
        return sprintf(
            '%s - %s - %s - %s - %s',
            $this->getVintageName(),
            $this->getYear(),
            $this->getDomain(),
            $this->getAppellation(),
            $this->getQuantity().' '.$this->getCapacityName().' '.$this->getLitrage()
        );
    }
}
