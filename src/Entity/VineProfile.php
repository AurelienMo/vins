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

use App\Entity\AdminMutators\VineProfileTrait;
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class VineProfile
 *
 * @ORM\Table(name="mps_vine_profile")
 * @ORM\Entity(repositoryClass="App\Repository\WineProfileRepository")
 */
class VineProfile extends AbstractEntity
{
    use VineProfileTrait;
    use NameTrait;
    use DescriptionTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $color;

    /**
     * @var Product[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="profile", cascade={"persist"})
     */
    protected $wines;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @return Product[]|Collection
     */
    public function getWines()
    {
        return $this->wines;
    }

    public function addWine(Product $product): VineProfile
    {
        $this->wines->add($product);
        $product->setProfile($this);

        return $this;
    }

    public function removeWine(Product $product): void
    {
        $this->wines->removeElement($product);
    }

    public function __toString()
    {
        return $this->name;
    }
}
