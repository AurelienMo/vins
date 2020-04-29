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

use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class NicheOfDelivery
 *
 * @ORM\Table(name="amo_niche_of_delivery")
 * @ORM\Entity(repositoryClass="App\Repository\NicheOfDeliveryRepository")
 */
class NicheOfDelivery extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateNiche;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     */
    protected $numberNiche;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="time")
     */
    protected $startAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="time")
     */
    protected $endAt;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return DateTime|null
     */
    public function getDateNiche(): ?DateTime
    {
        return $this->dateNiche;
    }

    /**
     * @param DateTime|null $dateNiche
     */
    public function setDateNiche(?DateTime $dateNiche): void
    {
        $this->dateNiche = $dateNiche;
    }

    /**
     * @return int|null
     */
    public function getNumberNiche(): ?int
    {
        return $this->numberNiche;
    }

    /**
     * @param int|null $numberNiche
     */
    public function setNumberNiche(?int $numberNiche): void
    {
        $this->numberNiche = $numberNiche;
    }

    public function updateNumberNiche()
    {
        $this->numberNiche--;
    }

    public function __toString()
    {
        return sprintf(
            '%s de %s à %s',
            $this->dateNiche->format('d/m/Y'),
            $this->startAt->format('H:i'),
            $this->endAt->format('H:i')
        );
    }

    public function getStartAt(): ?DateTime
    {
        return $this->startAt;
    }

    public function setStartAt(?DateTime $startAt): void
    {
        $this->startAt = $startAt;
    }

    public function getEndAt(): ?DateTime
    {
        return $this->endAt;
    }

    public function setEndAt(?DateTime $endAt): void
    {
        $this->endAt = $endAt;
    }
}
