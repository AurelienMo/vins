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

namespace App\Entity\Embedded;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class WineCaract
 *
 * @ORM\Embeddable()
 */
class WineCaract
{
    /**
     * @var int|null
     *
     * @Assert\NotBlank()
     * @Assert\Range(
     *     min=0,
     *     max=100
     * )
     */
    protected $fruity;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $taste;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $robustness;

    /**
     * @return int|null
     */
    public function getFruity(): ?int
    {
        return $this->fruity;
    }

    /**
     * @param int|null $fruity
     */
    public function setFruity(?int $fruity): void
    {
        $this->fruity = $fruity;
    }

    /**
     * @return string|null
     */
    public function getTaste(): ?string
    {
        return $this->taste;
    }

    /**
     * @param string|null $taste
     */
    public function setTaste(?string $taste): void
    {
        $this->taste = $taste;
    }

    /**
     * @return string|null
     */
    public function getRobustness(): ?string
    {
        return $this->robustness;
    }

    /**
     * @param string|null $robustness
     */
    public function setRobustness(?string $robustness): void
    {
        $this->robustness = $robustness;
    }
}
