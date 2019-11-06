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
     * @ORM\JoinColumn(name="amo_wine_id", referencedColumnName="id")
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
     * Opinion constructor.
     *
     * @param Product     $wine
     * @param string      $name
     * @param int         $rate
     * @param string|null $content
     */
    public function __construct(
        Product $wine,
        string $name,
        int $rate,
        ?string $content
    ) {
        $this->wine = $wine;
        $this->name = $name;
        $this->rate = $rate;
        $this->content = $content;
        $this->isValid = false;
        parent::__construct();
    }

    /**
     * @return Product
     */
    public function getWine(): Product
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
}
