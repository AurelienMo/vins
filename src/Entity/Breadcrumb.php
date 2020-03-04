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
 * @ORM\Table(name="amo_breadcrumb")
 * @ORM\Entity(repositoryClass="App\Repository\BreadcrumbRepository")
 *
 * @Vich\Uploadable()
 */
class Breadcrumb extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $page;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $imagePath;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="breadcrumb_images", fileNameProperty="imagePath")
     */
    protected $imageFile;

    public function getPage()
    {
        return $this->page;
    }

    public function setPage(?string $page): void
    {
        $this->page = $page;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

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
