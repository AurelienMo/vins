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

use App\Entity\Interfaces\Sluggable;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class WineDomain
 *
 * @ORM\Table(name="amo_wine_domain")
 * @ORM\Entity()
 */
class WineDomain extends AbstractEntity implements Sluggable
{
    use NameTrait;
    use SlugTrait;

    /**
     * @var Product[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="domain", cascade={"persist"})
     */
    protected $wines;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Product[]|Collection
     */
    public function getWines()
    {
        return $this->wines;
    }

    public function addWine(Product $wine): WineDomain
    {
        $this->wines->add($wine);
        $wine->setDomain($this);

        return $this;
    }

    public function removeWine(Product $wine): void
    {
        $this->wines->removeElement($wine);
    }

    public function __toString()
    {
        return $this->name;
    }
}
