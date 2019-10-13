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

use App\Entity\Traits\NameTrait;
use DateTime;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Promotion
 *
 * @ORM\Table(name="amo_promotion")
 * @ORM\Entity(repositoryClass="App\Repository\PromotionRepository")
 */
class Promotion extends AbstractEntity
{
    use NameTrait;

    /**
     * @var Product|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="promotions")
     * @ORM\JoinColumn(name="amo_product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * @var TypePromotion|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TypePromotion")
     * @ORM\JoinColumn(name="amo_type_promotion_id", referencedColumnName="id")
     */
    protected $typePromotion;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float")
     */
    protected $value;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime")
     */
    protected $startAt;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime")
     */
    protected $endAt;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     */
    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return TypePromotion|null
     */
    public function getTypePromotion(): ?TypePromotion
    {
        return $this->typePromotion;
    }

    /**
     * @param TypePromotion|null $typePromotion
     */
    public function setTypePromotion(?TypePromotion $typePromotion): void
    {
        $this->typePromotion = $typePromotion;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @param float|null $value
     */
    public function setValue(?float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return DateTime|null
     */
    public function getStartAt(): ?DateTime
    {
        return $this->startAt;
    }

    /**
     * @param DateTime|null $startAt
     */
    public function setStartAt(?DateTime $startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * @return DateTime|null
     */
    public function getEndAt(): ?DateTime
    {
        return $this->endAt;
    }

    /**
     * @param DateTime|null $endAt
     */
    public function setEndAt(?DateTime $endAt): void
    {
        $this->endAt = $endAt;
    }

    public function getStatus()
    {
        $dateNow = new DateTime();
        $this->status = null;
        if ($dateNow >= $this->startAt && $dateNow <= $this->endAt) {
            return 'En cours';
        }
        if ($dateNow > $this->endAt) {
            return 'Terminée';
        }
        if ($dateNow < $this->startAt) {
            return 'Non démarrée';
        }
    }
}
