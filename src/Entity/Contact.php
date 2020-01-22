<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <aurelien.morvan@infostrates.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Domain\Contact\Forms\ContactDTO;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 *
 * @ORM\Table(name="amo_contact")
 * @ORM\Entity()
 */
final class Contact extends AbstractEntity
{
    public const LIST_SUBJECT = [
        'Demande information' => 'Demande information',
        'Le concept' => 'Le concept',
        'Suivi de commande' => 'Suivi de commande',
        'Suggestion' => 'Suggestion',
        'Partenariat' => 'Partenariat',
        'Autre' => 'Autre',
    ];

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $subject;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $message;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $orderNumber;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isAnswered;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $anwseredOn;

    /**
     * Contact constructor.
     *
     * @param string      $subject
     * @param string      $name
     * @param string      $email
     * @param string|null $phoneNumber
     * @param string      $message
     * @param string|null $orderNumber
     */
    public function __construct(
        string $subject,
        string $name,
        string $email,
        string $message,
        ?string $phoneNumber,
        ?string $orderNumber
    ) {
        $this->subject = $subject;
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
        $this->orderNumber = $orderNumber;
        $this->isAnswered = false;
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    /**
     * @return bool
     */
    public function isAnswered(): bool
    {
        return $this->isAnswered;
    }

    /**
     * @return DateTime|null
     */
    public function getAnwseredOn(): ?DateTime
    {
        return $this->anwseredOn;
    }

    /**
     * @throws \Exception
     */
    public function answer(): void
    {
        $this->anwseredOn = new DateTime();
    }

    public static function create(ContactDTO $dto): Contact
    {
        return new self(
            $dto->getSubject(),
            $dto->getName(),
            $dto->getEmail(),
            $dto->getMessage(),
            $dto->getPhoneNumber(),
            $dto->getOrderNumber()
        );
    }
}
