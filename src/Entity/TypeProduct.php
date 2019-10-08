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
use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TypeProduct
 *
 * @ORM\Table(name="amo_type_product")
 * @ORM\Entity(repositoryClass="App\Repository\TypeProductRepository")
 */
class TypeProduct extends AbstractEntity implements Sluggable, UpdatableInterface
{
    use NameTrait;
    use SlugTrait;
    use TimeStampableTrait;

    /**
     * @var Product[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="typeProduct", cascade={"persist", "remove"})
     */
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Product[]|Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function addProduct(Product $product)
    {
        $this->products->add($product);
        $product->setTypeProduct($this);

        return $this;
    }

    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }

    public function __toString()
    {
        return $this->name;
    }
}
