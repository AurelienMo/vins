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
use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class VineProfile
 *
 * @ORM\Table(name="mps_vine_profile")
 * @ORM\Entity(repositoryClass="App\Repository\WineProfileRepository")
 *
 * @Vich\Uploadable()
 */
class VineProfile extends AbstractEntity implements UpdatableInterface
{
    use VineProfileTrait;
    use NameTrait;
    use DescriptionTrait;
    use TimeStampableTrait;

    public const RED_TYPE_PROFILE = 'Les rouges';
    public const WHITE_TYPE_PROFILE = 'Les blancs';
    public const PINK_TYPE_PROFILE = 'Les rosés';

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

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $type;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $colorText;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $imagePath;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="wine_profile_images", fileNameProperty="imagePath")
     */
    protected $imageFile;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
        $this->colorText = '#000000';
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

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getColorText(): ?string
    {
        return $this->colorText;
    }

    /**
     * @param string|null $colorText
     */
    public function setColorText(?string $colorText): void
    {
        $this->colorText = $colorText;
    }

    /**
     * @return string|null
     */
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    /**
     * @param string|null $imagePath
     */
    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTime();
        }
    }
}
