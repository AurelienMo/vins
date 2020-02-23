<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="amo_wine_agreement")
 * @ORM\Entity()
 */
class WineAgreement extends AbstractEntity
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", name="order_value")
     */
    protected $order;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): void
    {
        $this->order = $order;
    }

    public function __toString()
    {
        return $this->name;
    }
}
