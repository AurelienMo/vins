<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\ORM\Mapping as ORM;
use File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="amo_slider_home")
 * @ORM\Entity()
 *
 * @Vich\Uploadable()
 */
class SliderHome extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="slider_home_images", fileNameProperty="image")
     *
     * @Assert\Image(
     *     minHeight="300px",
     *     maxHeight="420px"
     * )
     */
    protected $imageFile;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $link;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $order;

    public function getLink()
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(?int $order): void
    {
        $this->order = $order;
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
}
