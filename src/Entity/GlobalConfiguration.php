<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use Doctrine\ORM\Mapping as ORM;
use File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="amo_global_configuration")
 * @ORM\Entity(repositoryClass="App\Repository\GlobalConfigurationRepository")
 *
 * @Vich\Uploadable()
 */
class GlobalConfiguration extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $imageHomepage;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="global_images", fileNameProperty="imageHomepage")
     */
    protected $imageHomepageFile;

    public function getImageHomepage(): ?string
    {
        return $this->imageHomepage;
    }

    public function setImageHomepage(?string $imageHomepage): void
    {
        $this->imageHomepage = $imageHomepage;
    }

    public function getImageHomepageFile()
    {
        return $this->imageHomepageFile;
    }

    public function setImageHomepageFile($imageHomepageFile = null): void
    {
        $this->imageHomepageFile = $imageHomepageFile;

        if ($imageHomepageFile) {
            $this->updatedAt = new \DateTime();
        }
    }
}
