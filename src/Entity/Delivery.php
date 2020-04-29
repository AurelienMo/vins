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

use App\Admin\Traits\ValueListTrait;
use App\Domain\Cart\Delivery\Forms\DeliveryDTO;
use App\Entity\Interfaces\UpdatableInterface;
use App\Entity\Traits\TimeStampableTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Delivery
 *
 * @ORM\Table(name="amo_delivery")
 * @ORM\Entity()
 */
class Delivery extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;
    use ValueListTrait;

    public const DELIVERY_IN_PROGRESS = 'Livraison en cours';
    public const DELIVERED_AT_ADDRESS = 'Livré à l\'adresse';
    public const DELIVERY_AT_VOISIN = 'Déposé chez un voisin';
    public const DELIVERY_MISS = 'Absent';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $statusDate;

    /**
     * @var NicheOfDelivery|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\NicheOfDelivery")
     * @ORM\JoinColumn(name="amo_niche_of_delivery_id", referencedColumnName="id", nullable=true)
     */
    protected $niche;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", cascade={"remove"}, inversedBy="delivery")
     * @ORM\JoinColumn(name="amo_order_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $order;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $commentDelivery;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $personIfAbsent;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $typeDelivery;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $descriptionOptionnal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $deliveryDate;

    public function __construct(
        ?NicheOfDelivery $niche = null,
        ?string $comment = null,
        ?string $typeDelivery = null,
        ?string $personIfAbsent = null
    ) {
        $this->niche = $niche;
        $this->commentDelivery = $comment;
        $this->typeDelivery = $typeDelivery;
        $this->personIfAbsent = $personIfAbsent;
        $this->status = self::DELIVERY_IN_PROGRESS;
        $this->statusDate = new DateTime();
        parent::__construct();
    }

    public static function createFromPayment(?DeliveryDTO $dto, ?NicheOfDelivery $niche = null)
    {
        if ($niche instanceof NicheOfDelivery) {
            $niche->updateNumberNiche();
        }
        $delivery = new self(
            $niche,
            $dto->getComment(),
            $dto->getTypeDelivery(),
            $dto->getPersonIfAbsent()
        );
        $delivery->setDeliveryDate();

        return $delivery;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatusDate(): DateTime
    {
        return $this->statusDate;
    }

    public function getNiche()
    {
        return $this->niche;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function getCommentDelivery(): ?string
    {
        return $this->commentDelivery;
    }

    public function getPersonIfAbsent(): ?string
    {
        return $this->personIfAbsent;
    }

    public function getTypeDelivery(): ?string
    {
        return $this->typeDelivery;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getContentText(): string
    {
        $text = null;
        if ($this->getTypeDelivery() === 'basic' || $this->getTypeDelivery() === 'free') {
            $text = "sous 3 jours ouvrés";
        } else {
            $date = $this->getNiche()->getDateNiche()->format('d/m/Y');
            $hour = ' entre '.$this->getNiche()->getStartAt()->format('H:i').' et '.$this->getNiche()->getEndAt()->format('H:i');
            $text = "le ".$date.$hour;
        }

        return $text;
    }

    public function __toString()
    {
        return sprintf('Livraison %s', $this->getContentText());
    }

    public function getAddress(): ?string
    {
        return $this->order instanceof Order ?
         $this->order->getCustomer()->getFullAddress() : $this->getDescriptionOptionnal();
    }
//
//    public function getDateDelivery()
//    {
//        if (!\is_null($this->niche)) {
//            return $this->niche;
//        }
//
//        $this->createdAt->modify('+36 hours');
//
//        return $this->createdAt->format('d/m/Y');
//    }

    /**
     * @param DateTime $statusDate
     */
    public function setStatusDate(DateTime $statusDate): void
    {
        $this->statusDate = $statusDate;
    }

    /**
     * @param NicheOfDelivery|null $niche
     */
    public function setNiche(?NicheOfDelivery $niche): void
    {
        $this->niche = $niche;
    }

    /**
     * @param string|null $commentDelivery
     */
    public function setCommentDelivery(?string $commentDelivery): void
    {
        $this->commentDelivery = $commentDelivery;
    }

    /**
     * @param string|null $personIfAbsent
     */
    public function setPersonIfAbsent(?string $personIfAbsent): void
    {
        $this->personIfAbsent = $personIfAbsent;
    }

    /**
     * @param string|null $typeDelivery
     */
    public function setTypeDelivery(?string $typeDelivery): void
    {
        $this->typeDelivery = $typeDelivery;
    }

    /**
     * @return string|null
     */
    public function getDescriptionOptionnal(): ?string
    {
        return $this->descriptionOptionnal;
    }

    /**
     * @param string|null $descriptionOptionnal
     */
    public function setDescriptionOptionnal(?string $descriptionOptionnal): void
    {
        $this->descriptionOptionnal = $descriptionOptionnal;
    }

    public function getPrice()
    {
        $price = 0;
        switch ($this->typeDelivery) {
            case 'basic':
                $price = 4;
                break;
            case 'express':
                $price = 6;
                break;
        }

        return $price;
    }

    /**
     * @return DateTime
     */
    public function getDeliveryDate(): DateTime
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(): void
    {
        $date = null;
        switch ($this->typeDelivery) {
            case 'basic':
            case 'free':
                $date = DateTime::createFromFormat('Y/m/d H:i:s', $this->createdAt->format('Y/m/d').' 00:00:00')->modify('+3 days');
                switch ($date->format('D')) {
                    case 'Sat':
                        $date->modify('+2 days');
                        break;
                    case 'Sun':
                        $date->modify('+1 days');
                }
                break;
            case 'express':
                $niche = $this->getNiche();
                $date = DateTime::createFromFormat(
                    'Y/m/d H:i:s',
                    $niche->getDateNiche()->format('Y/m/d').' '.$niche->getStartAt()->format('H:i:s')
                );
                break;
        }

        $this->deliveryDate = $date;
    }
}
