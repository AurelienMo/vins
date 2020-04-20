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

use App\Entity\Interfaces\OpinionElementInterface;
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
 * Class BoxWine
 *
 * @ORM\Table(name="amo_box_wine")
 * @ORM\Entity(repositoryClass="App\Repository\BoxWineRepository")
 *
 * @Vich\Uploadable()
 */
class BoxWine extends AbstractEntity implements OpinionElementInterface, UpdatableInterface
{
    use NameTrait;
    use DescriptionTrait;
    use TimeStampableTrait;

    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    /**
     * @var Capacity[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Capacity")
     * @ORM\JoinTable(name="box_wine_has_capacities",
     *     joinColumns={@ORM\JoinColumn(name="box_wine_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="capacity_id", referencedColumnName="id")}
     *     )
     */
    protected $wines;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $shortPhrase;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imagePath;

    /**
     * @Vich\UploadableField(mapping="box_images", fileNameProperty="imagePath")
     * @var File
     */
    private $imageFile;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float")
     */
    protected $price;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $color;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @return Capacity[]|Collection
     */
    public function getWines()
    {
        return $this->wines;
    }

    public function setIsActive(?bool $isActive)
    {
        $this->isActive = $isActive;
    }

    public function addCapacity(Capacity $capacity)
    {
        $this->wines->add($capacity);
    }

    public function removeCapaciy(Capacity $capacity)
    {
        $this->wines->removeElement($capacity);
    }

    /**
     * @return string|null
     */
    public function getShortPhrase(): ?string
    {
        return $this->shortPhrase;
    }

    /**
     * @param string|null $shortPhrase
     */
    public function setShortPhrase(?string $shortPhrase): void
    {
        $this->shortPhrase = $shortPhrase;
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
    public function setImagePath($imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile($imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updateAt = new \DateTime('now');
        }
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     */
    public function setColor(?string $color): void
    {
        $this->color = $color;
    }
}
