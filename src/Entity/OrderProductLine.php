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

use App\Domain\Cart\ValueObject\BoxVO;
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
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $vintageName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $year;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $domain;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $appellation;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $capacityName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
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

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $boxName;

    public function __construct(
        float $unitPrice,
        int $quantity,
        ?string $boxName = null,
        ?string $vintageName = null,
        ?string $year = null,
        ?string $domain = null,
        ?string $appellation = null,
        ?string $capacityName = null,
        ?string $litrage = null,
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
        $this->boxName = $boxName;
        parent::__construct();
    }

    public function getVintageName(): ?string
    {
        return $this->vintageName;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function getAppellation(): ?string
    {
        return $this->appellation;
    }

    public function getCapacityName(): ?string
    {
        return $this->capacityName;
    }

    public function getLitrage(): ?string
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

    /**
     * @param ProductVO|BoxVO $vo
     * @return OrderProductLine
     */
    public static function create($vo)
    {
        return new self(
            $vo->getUnitPrice(),
            $vo->getQuantity(),
            $vo instanceof BoxVO ? $vo->getBox()->getName() : null,
            $vo instanceof ProductVO ? $vo->getProduct()->getVintageName() : null,
            $vo instanceof ProductVO ? $vo->getProduct()->getYear() : null,
            $vo instanceof ProductVO ? $vo->getDomain()->getName() : null,
            $vo instanceof ProductVO ? $vo->getProduct()->getAppellation() : null,
            $vo instanceof ProductVO ? $vo->getCapacity()->getType() : null,
            $vo instanceof ProductVO ? $vo->getCapacity()->getQuantity() . 'L' : null,
            $vo instanceof ProductVO ? $vo->getPricePromo() : null
        );
    }

    /**
     * @return string|null
     */
    public function getBoxName(): ?string
    {
        return $this->boxName;
    }

    public function __toString()
    {
        if ($this->boxName) {
            return $this->boxName;
        }

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
