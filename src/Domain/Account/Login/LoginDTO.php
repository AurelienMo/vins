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

namespace App\Domain\Account\Login;

/**
 * Class LoginDTO
 */
final class LoginDTO
{
    /**
     * @var string|null
     */
    protected $identifier;

    /**
     * @var string|null
     */
    protected $password;

    /**
     * LoginDTO constructor.
     *
     * @param string|null $identifier
     * @param string|null $password
     */
    public function __construct(
        ?string $identifier,
        ?string $password
    ) {
        $this->identifier = $identifier;
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
