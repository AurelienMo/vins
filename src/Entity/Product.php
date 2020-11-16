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

use App\Domain\Common\Helpers\PromotionCalculate;
use App\Entity\Embedded\WineCaract;
use App\Entity\Embedded\WineService;
use App\Entity\Interfaces\OpinionElementInterface;
use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Product
 *
 * @ORM\Table(name="amo_product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 *
 * @Vich\Uploadable()
 */
class Product extends AbstractEntity implements UpdatableInterface, OpinionElementInterface
{
    use TimeStampableTrait;

    /**
     * @var WineDomain|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\WineDomain", inversedBy="wines", fetch="EAGER")
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imagePath;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imagePath")
     * @var File
     */
    private $imageFile;

    /**
     * @var Quizz[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Quizz", mappedBy="wine", cascade={"persist", "remove"})
     */
    protected $quizzs;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shortPhrase;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $alcoholDegree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $firstBadge;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="firstBadge")
     * @var File
     */
    private $firstBadgeFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $secondBadge;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="secondBadge")
     * @var File
     */
    private $secondBadgeFile;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $region;

    /**
     * @var WineAgreement[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\WineAgreement")
     */
    protected $agreements;

    /**
     * @var WineDish[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\WineDish", mappedBy="wine", cascade={"persist", "remove"})
     */
    protected $dishes;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tastingSheetPath;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="tasting_sheet_pdf", fileNameProperty="tastingSheetPath")
     */
    protected $tastingSheetFile;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
        $this->wineCaract = new WineCaract();
        $this->wineService = new WineService();
        $this->active = false;
        $this->isPromote = false;
        $this->opinions = new ArrayCollection();
        $this->capacities = new ArrayCollection();
        $this->quizzs = new ArrayCollection();
        $this->agreements = new ArrayCollection();
        $this->dishes = new ArrayCollection();
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
        $text = '';
        if ($this->domain) {
            $text .= $this->domain . ' - ';
        }
        return sprintf(
            '%s%s - %s - %s',
            $text,
            $this->appellation,
            $this->vintageName,
            $this->typeProduct->getName()
        );
    }

    public function setImageFile($image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return Quizz[]|Collection
     */
    public function getQuizzs()
    {
        return $this->quizzs;
    }

    public function addQuizz(Quizz $quizz)
    {
        $this->quizzs->add($quizz);
        $quizz->setWine($this);

        return $this;
    }

    public function removeQuizz(Quizz $quizz)
    {
        $this->quizzs->removeElement($quizz);
    }

    public function getShortPhrase(): ?string
    {
        return $this->shortPhrase;
    }

    public function setShortPhrase(?string $shortPhrase): void
    {
        $this->shortPhrase = $shortPhrase;
    }

    public function getAlcoholDegree(): ?string
    {
        return $this->alcoholDegree;
    }

    public function setAlcoholDegree(?string $alcoholDegree): void
    {
        $this->alcoholDegree = $alcoholDegree;
    }

    public function averageRate()
    {
        $total = 0;
        $this->opinions->toArray();
        foreach ($this->opinions as $opinion) {
            $total += $opinion->getRate();
        }

        return $this->opinions->count() > 0 ? round($total / $this->opinions->count()) : 0;
    }

    public function getLowerCapacityPrice()
    {
        $capacities = $this->capacities->toArray();
        usort($capacities, [$this, 'compareCapacityPrice']);
        /** @var Promotion $promotion */
        $promotion = $this->promotions->filter(function (Promotion $promotion) {
            return $promotion->getStatus() === Promotion::IN_PROGRESS;
        })->current();

        $capacityFinal = null;
        /** @var Capacity $capacity */
        foreach ($capacities as $capacity) {
            if ($capacity->getStock()->getQuantity() <= 0) {
                continue;
            }

            $capacityFinal = $capacity;
            break;
        }
        if (is_null($capacityFinal)) {
            $capacityFinal = current($capacities);
        }

        return [
            'priceInit' => $capacityFinal instanceof Capacity ? $capacityFinal->getUnitPrice() : 'N/A',
            'pricePromo' => $promotion instanceof Promotion && $capacityFinal instanceof Capacity ?
                PromotionCalculate::calcultePromoForProduct($capacityFinal, $promotion) : null,
        ];
    }

    private function compareCapacityPrice(Capacity $a, Capacity $b)
    {
        return $a->getUnitPrice() <=> $b->getUnitPrice();
    }

    public function setFirstBadgeFile($image = null)
    {
        $this->firstBadgeFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getFirstBadgeFile()
    {
        return $this->firstBadgeFile;
    }

    /**
     * @return string
     */
    public function getFirstBadge()
    {
        return $this->firstBadge;
    }

    /**
     * @param string $imagePath
     */
    public function setFirstBadge(?string $imagePath): void
    {
        $this->firstBadge = $imagePath;
    }

    public function setSecondBadgeFile($image = null)
    {
        $this->secondBadgeFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getSecondBadgeFile()
    {
        return $this->secondBadgeFile;
    }

    /**
     * @return string
     */
    public function getSecondBadge()
    {
        return $this->secondBadge;
    }

    /**
     * @param string $imagePath
     */
    public function setSecondBadge(?string $imagePath): void
    {
        $this->secondBadge = $imagePath;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getAgreements()
    {
        return $this->agreements;
    }

    public function addAgreement(WineAgreement $agreement)
    {
        $this->agreements->add($agreement);

        return $this;
    }

    public function removeAgreement(WineAgreement $agreement)
    {
        $this->agreements->removeElement($agreement);
    }

    public function getDishes()
    {
        return $this->dishes;
    }

    public function addDish(WineDish $dish)
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes->add($dish);
            $dish->setWine($this);
        }

        return $this;
    }

    public function removeDish(WineDish $dish)
    {
        if ($this->dishes->contains($dish)) {
            $this->dishes->removeElement($dish);
        }
    }

    public function countElementOpinion(string $type, bool $average = false)
    {
        $opinions = $this->opinions->toArray();
        $cpt = 0;
        $total = 0;

        /** @var Opinion $opinion */
        foreach ($opinions as $opinion) {
            switch ($type) {
                case 'rate':
                    if ($opinion->getRate()) {
                        $cpt += $opinion->getRate();
                        $total++;
                    }
                    break;
                case 'comment':
                    if ($opinion->getContent()) {
                        $total++;
                    }
                    break;
            }
        }
        if ($type === 'comment') {
            return $total;
        }

        return $total === 0 ? 0 : round($cpt / $total, 2);
    }

    public function listTypeCapacities()
    {
        $type = [];
        /** @var Capacity $capacity */
        foreach ($this->capacities as $capacity) {
            if (!in_array($capacity->getType(), $type) && $capacity->getStock()->getQuantity() > 0) {
                $type[] = $capacity->getType() === 'Cubis' ? 'BagInBox' : $capacity->getType();
            }
        }

        return implode(', ', $type);
    }

    public function hasStock(): bool
    {
        foreach ($this->capacities as $capacity) {
            if ($capacity->getStock()->getQuantity() > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getTastingSheetPath(): ?string
    {
        return $this->tastingSheetPath;
    }

    /**
     * @param string|null $tastingSheetPath
     */
    public function setTastingSheetPath(?string $tastingSheetPath): void
    {
        $this->tastingSheetPath = $tastingSheetPath;
    }

    /**
     * @return File
     */
    public function getTastingSheetFile()
    {
        return $this->tastingSheetFile;
    }

    /**
     * @param File $tastingSheetFile
     */
    public function setTastingSheetFile($tastingSheetFile = null): void
    {
        $this->tastingSheetFile = $tastingSheetFile;
        if ($tastingSheetFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }
}
