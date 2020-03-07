<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="amo_tastuce_theme")
 * @ORM\Entity(repositoryClass="App\Repository\TastuceThemeRepository")
 *
 * @Vich\Uploadable()
 */
class TastuceTheme extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="tastuce_theme_images", fileNameProperty="image")
     *
     */
    protected $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $color;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $colorText;

    /**
     * @var Tastuce[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Tastuce", mappedBy="theme", cascade={"persist", "remove"})
     *
     * @Assert\Valid()
     */
    protected $tastuces;

    public function __construct()
    {
        $this->tastuces = new ArrayCollection();
        parent::__construct();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
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

    public function getColor()
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getColorText()
    {
        return $this->colorText;
    }

    public function setColorText(string $colorText): void
    {
        $this->colorText = $colorText;
    }

    public function getTastuces()
    {
        return $this->tastuces;
    }

    public function addTastuce(Tastuce $tastuce)
    {
        if (!$this->tastuces->contains($tastuce)) {
            $this->tastuces->add($tastuce);
            $tastuce->setTheme($this);
        }

        return $this;
    }

    public function removeTastuce(Tastuce $tastuce)
    {
        if ($this->tastuces->contains($tastuce)) {
            $this->tastuces->removeElement($tastuce);
            $tastuce->setTheme(null);
        }
    }
}
