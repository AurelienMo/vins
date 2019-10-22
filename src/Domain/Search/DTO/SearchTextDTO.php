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

namespace App\Domain\Search\DTO;

/**
 * Class SearchTextDTO
 */
class SearchTextDTO
{
    /** @var string|null */
    protected $text;

    /**
     * SearchTextDTO constructor.
     *
     * @param string|null $text
     */
    public function __construct(
        ?string $text
    ) {
        $this->text = $text;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }
}
