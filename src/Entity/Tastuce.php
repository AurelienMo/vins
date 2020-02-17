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
 * @ORM\Table(name="amo_tastuce")
 * @ORM\Entity()
 *
 * @Vich\Uploadable()
 */
class Tastuce extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $pdfPath;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="tastuce_theme_images", fileNameProperty="pdfPath")
     *
     * @Assert\File(
     *     mimeTypes={"application/pdf"}
     * )
     */
    protected $pdfFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $textLink;

    /**
     * @var TastuceTheme|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TastuceTheme", inversedBy="tastuces")
     * @ORM\JoinColumn(name="tastuce_theme_id", referencedColumnName="id", nullable=true)
     */
    protected $theme;

    public function __toString()
    {
        return $this->textLink;
    }

    public function getPdfPath()
    {
        return $this->pdfPath;
    }

    public function setPdfPath(?string $pdfPath): void
    {
        $this->pdfPath = $pdfPath;
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

    public function getTextLink()
    {
        return $this->textLink;
    }

    public function setTextLink(string $textLink): void
    {
        $this->textLink = $textLink;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setTheme(?TastuceTheme $theme): void
    {
        $this->theme = $theme;
    }
}
