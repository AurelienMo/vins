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
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TimeStampableTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class WineDomain
 *
 * @ORM\Table(name="amo_wine_domain")
 * @ORM\Entity()
 *
 * @Vich\Uploadable()
 */
class WineDomain extends AbstractEntity implements Sluggable, UpdatableInterface
{
    use SlugTrait;
    use TimeStampableTrait;
    use DescriptionTrait;

    /**
     * @var Product[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="domain", cascade={"persist"})
     */
    protected $wines;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $winegrowerPicture;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="domain_images", fileNameProperty="winegrowerPicture")
     */
    protected $winegrowerPictureFile;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $terroir;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank()
     */
    protected $name;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
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

    /**
     * @return string|null
     */
    public function getWinegrowerName(): ?string
    {
        return $this->winegrowerName;
    }

    /**
     * @param string|null $winegrowerName
     */
    public function setWinegrowerName(?string $winegrowerName): void
    {
        $this->winegrowerName = $winegrowerName;
    }

    /**
     * @return string|null
     */
    public function getWinegrowerPicture(): ?string
    {
        return $this->winegrowerPicture;
    }

    /**
     * @param string|null $winegrowerPicture
     */
    public function setWinegrowerPicture(?string $winegrowerPicture): void
    {
        $this->winegrowerPicture = $winegrowerPicture;
    }

    /**
     * @return File
     */
    public function getWinegrowerPictureFile()
    {
        return $this->winegrowerPictureFile;
    }

    /**
     * @param File $winegrowerPictureFile
     */
    public function setWinegrowerPictureFile($winegrowerPictureFile = null): void
    {
        $this->winegrowerPictureFile = $winegrowerPictureFile;
        if ($winegrowerPictureFile) {
            $this->updatedAt = new DateTime();
        }
    }

    /**
     * @return string|null
     */
    public function getTerroir(): ?string
    {
        return $this->terroir;
    }

    /**
     * @param string|null $terroir
     */
    public function setTerroir(?string $terroir): void
    {
        $this->terroir = $terroir;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function __toString()
    {
        return $this->name;
    }
}
