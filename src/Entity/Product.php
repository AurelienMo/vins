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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 *
 * @ORM\Table(name="amo_product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var WineDomain|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\WineDomain", inversedBy="wines")
     * @ORM\JoinColumn(name="amo_wine_domain_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $domain;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $vintageName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $year;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $appellation;

    /**
     * @var Promotion[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Promotion", mappedBy="product", cascade={"persist", "remove"})
     */
    protected $promotions;

    /**
     * @var TypeProduct|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeProduct", inversedBy="products")
     * @ORM\JoinColumn(name="amo_type_product_id", referencedColumnName="id")
     */
    protected $typeProduct;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Promotion[]|Collection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion)
    {
        $this->promotions->add($promotion);

        return $this;
    }

    public function removePromotion(Promotion $promotion)
    {
        $this->promotions->removeElement($promotion);
    }

    /**
     * @return WineDomain|null
     */
    public function getDomain(): ?WineDomain
    {
        return $this->domain;
    }

    /**
     * @param WineDomain|null $domain
     */
    public function setDomain(?WineDomain $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string|null
     */
    public function getVintageName(): ?string
    {
        return $this->vintageName;
    }

    /**
     * @param string|null $vintageName
     */
    public function setVintageName(?string $vintageName): void
    {
        $this->vintageName = $vintageName;
    }

    /**
     * @return string|null
     */
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * @param string|null $year
     */
    public function setYear(?string $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string|null
     */
    public function getAppellation(): ?string
    {
        return $this->appellation;
    }

    /**
     * @param string|null $appellation
     */
    public function setAppellation(?string $appellation): void
    {
        $this->appellation = $appellation;
    }

    /**
     * @return TypeProduct|null
     */
    public function getTypeProduct(): ?TypeProduct
    {
        return $this->typeProduct;
    }

    /**
     * @param TypeProduct|null $typeProduct
     */
    public function setTypeProduct(?TypeProduct $typeProduct): void
    {
        $this->typeProduct = $typeProduct;
    }
}
