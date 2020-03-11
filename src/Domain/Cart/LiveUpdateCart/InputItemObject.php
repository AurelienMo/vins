<?php

declare(strict_types=1);

namespace App\Domain\Cart\LiveUpdateCart;

class InputItemObject
{
    /** @var string */
    protected $id;

    /** @var int */
    protected $actual;

    /** @var int */
    protected $new;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getActual(): int
    {
        return $this->actual;
    }

    public function setActual(int $actual): void
    {
        $this->actual = $actual;
    }

    public function getNew(): int
    {
        return $this->new;
    }

    public function setNew(int $new): void
    {
        $this->new = $new;
    }
}
