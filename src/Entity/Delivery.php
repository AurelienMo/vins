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

    public const DELIVERY_IN_PROGRESS = 'Livraison en cours';
    public const DELIVERED_AT_ADDRESS = 'Livré à l\'adresse';

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
     * @ORM\OneToOne(targetEntity="App\Entity\Order", cascade={"remove"}, inversedBy="delivery")
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
        return new self(
            $niche,
            $dto->getComment(),
            $dto->getTypeDelivery(),
            $dto->getPersonIfAbsent()
        );
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusDate(): DateTime
    {
        return $this->statusDate;
    }

    public function getNiche(): ?NicheOfDelivery
    {
        return $this->niche;
    }

    public function getOrder(): Order
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
        if ($this->getTypeDelivery() === 'basic') {
            $text = "sous 3 jours";
        } else {
            $date = $this->getNiche()->getDateNiche()->format('d/m/Y');
            $hour = ' entre '.$this->getNiche()->getStartAt()->format('H:i').' et '.$this->getNiche()->getEndAt()->format('H:i');
            $text = "le ".$date.$hour;
        }

        return $text;

    }
}
