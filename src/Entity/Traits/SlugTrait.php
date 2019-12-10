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

namespace App\Entity\Traits;

use App\Domain\Common\Helpers\SlugifyHelper;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait SlugTrait
 */
trait SlugTrait
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = SlugifyHelper::slugify((string) $slug);
    }
}
