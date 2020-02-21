<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\ORM\Mapping as ORM;
use File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="amo_slider_mpmd")
 * @ORM\Entity(repositoryClass="App\Repository\SliderMPMDRepository")
 *
 * @Vich\Uploadable()
 */
class SliderMPMD extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $pdf;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="slider_mpmd_images", fileNameProperty="image")
     */
    protected $imageFile;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="slider_mpmd_file", fileNameProperty="pdf")
     */
    protected $pdfFile;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getPdf()
    {
        return $this->pdf;
    }

    public function setPdf(?string $pdf): void
    {
        $this->pdf = $pdf;
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

    public function getPdfFile()
    {
        return $this->pdfFile;
    }

    public function setPdfFile($pdfFile = null): void
    {
        $this->pdfFile = $pdfFile;
        if ($pdfFile) {
            $this->updatedAt = new \DateTime();
        }
    }
}
