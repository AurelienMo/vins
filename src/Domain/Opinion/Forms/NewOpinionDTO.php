<?php

declare(strict_types=1);

namespace App\Domain\Opinion\Forms;

use Symfony\Component\Validator\Constraints as Assert;

class NewOpinionDTO
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var int|null
     *
     * @Assert\Range(
     *     min="0",
     *     max="5"
     * )
     */
    protected $rate = 0;

    /**
     * @var string|null
     */
    protected $content;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): void
    {
        $this->rate = $rate;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }
}
