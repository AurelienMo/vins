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

use App\Entity\Embedded\WineCaract;
use App\Entity\Embedded\WineService;
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

    /**
     * @var WineCaract
     *
     * @ORM\Embedded(class="App\Entity\Embedded\WineCaract")
     */
    protected $wineCaract;

    /**
     * @var WineService
     *
     * @ORM\Embedded(class="App\Entity\Embedded\WineService")
     */
    protected $wineService;

    /**
     * @var VineProfile|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\VineProfile", inversedBy="wines")
     * @ORM\JoinColumn(name="amo_profile_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $profile;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float")
     */
    protected $tvaRate;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isPromote;

    /**
     * @var Opinion[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Opinion", mappedBy="wine", cascade={"persist", "remove"})
     */
    protected $opinions;

    /**
     * @var Capacity[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Capacity", mappedBy="wine", cascade={"persist", "remove"})
     */
    protected $capacities;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        $this->wineCaract = new WineCaract();
        $this->wineService = new WineService();
        $this->active = false;
        $this->isPromote = false;
        $this->opinions = new ArrayCollection();
        $this->capacities = new ArrayCollection();
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

    /**
     * @return WineCaract
     */
    public function getWineCaract(): WineCaract
    {
        return $this->wineCaract;
    }

    /**
     * @param WineCaract $wineCaract
     */
    public function setWineCaract(WineCaract $wineCaract): void
    {
        $this->wineCaract = $wineCaract;
    }

    /**
     * @return WineService
     */
    public function getWineService(): WineService
    {
        return $this->wineService;
    }

    /**
     * @param WineService $wineService
     */
    public function setWineService(WineService $wineService): void
    {
        $this->wineService = $wineService;
    }

    /**
     * @return VineProfile|null
     */
    public function getProfile(): ?VineProfile
    {
        return $this->profile;
    }

    /**
     * @param VineProfile|null $profile
     */
    public function setProfile(?VineProfile $profile): void
    {
        $this->profile = $profile;
    }

    /**
     * @return float|null
     */
    public function getTvaRate(): ?float
    {
        return $this->tvaRate;
    }

    /**
     * @param float|null $tvaRate
     */
    public function setTvaRate(?float $tvaRate): void
    {
        $this->tvaRate = $tvaRate;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return bool
     */
    public function isPromote(): bool
    {
        return $this->isPromote;
    }

    /**
     * @param bool $isPromote
     */
    public function setIsPromote(bool $isPromote): void
    {
        $this->isPromote = $isPromote;
    }

    /**
     * @return Opinion[]|Collection
     */
    public function getOpinions()
    {
        return $this->opinions;
    }

    /**
     * @return Capacity[]|Collection
     */
    public function getCapacities()
    {
        return $this->capacities;
    }

    /**
     * @param Capacity[]|Collection $capacities
     */
    public function setCapacities($capacities): void
    {
        $this->capacities = $capacities;
    }

    public function addCapacity(Capacity $capacity)
    {
        $this->capacities->add($capacity);
        $capacity->setWine($this);

        return $this;
    }

    public function removeCapacity(Capacity $capacity)
    {
        $this->capacities->removeElement($capacity);
    }

    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->domain,
            $this->appellation
        );
    }
}
