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

use App\Domain\Opinion\Forms\NewOpinionDTO;
use App\Entity\Interfaces\OpinionElementInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Opinion
 *
 * @ORM\Table(name="amo_opinion")
 * @ORM\Entity()
 */
class Opinion extends AbstractEntity
{
    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="opinions")
     * @ORM\JoinColumn(name="amo_wine_id", referencedColumnName="id", nullable=true)
     */
    protected $wine;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $rate;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isValid;

    /**
     * @var BoxWine|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\BoxWine", inversedBy="opinions")
     * @ORM\JoinColumn(name="amo_box_id", referencedColumnName="id", nullable=true)
     */
    protected $box;

    /**
     * Opinion constructor.
     *
     * @param string      $name
     * @param int         $rate
     * @param string|null $content
     */
    public function __construct(
        string $name,
        int $rate,
        ?string $content
    ) {
        $this->name = $name;
        $this->rate = $rate;
        $this->content = $content;
        $this->isValid = false;
        parent::__construct();
    }

    public static function createFromDTO(NewOpinionDTO $dto, $productElement)
    {
        $opinion = new self($dto->getName(), $dto->getRate(), $dto->getContent());
        $opinion->affectElement($productElement);

        return $opinion;
    }

    /**
     * @return Product|null
     */
    public function getWine(): ?Product
    {
        return $this->wine;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getRate(): int
    {
        return $this->rate;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     */
    public function setIsValid(bool $isValid): void
    {
        $this->isValid = $isValid;
    }

    private function affectElement(OpinionElementInterface $productElement)
    {
        switch (get_class($productElement)) {
            case Product::class:
                $this->wine = $productElement;
                break;
            case BoxWine::class:
                $this->box = $productElement;
                break;
        }
    }

    /**
     * @return BoxWine|null
     */
    public function getBox(): ?BoxWine
    {
        return $this->box;
    }
}
