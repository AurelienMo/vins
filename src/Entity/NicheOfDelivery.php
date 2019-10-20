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
     * @var Delivery[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Delivery", mappedBy="niche", cascade={"persist", "remove"})
     */
    protected $deliveries;

    public function __construct()
    {
        $this->deliveries = new ArrayCollection();
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

    /**
     * @return Delivery[]|Collection
     */
    public function getDeliveries()
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery)
    {
        $this->deliveries->add($delivery);
        $delivery->setNiche($this);

        return $this;
    }

    public function __toString()
    {
        $cptRest = $this->numberNiche - $this->deliveries->count();
        return sprintf(
            '%s (%s créneaux restants)',
            $this->dateNiche->format('d/m/Y'),
            $cptRest
        );
    }
}
