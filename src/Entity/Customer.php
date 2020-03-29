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
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 *
 * @ORM\Table(name="amo_customer")
 * @ORM\Entity()
 */
class Customer extends AbstractEntity implements UpdatableInterface
{
    use TimeStampableTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $phoneNumber;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $rgpdAcceptedAt;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $addressCustomer;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $zipCode;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $city;

    public function __construct(
        ?string $firstname = null,
        ?string $lastname = null,
        ?string $email = null,
        ?string $phoneNumber = null,
        ?string $address = null,
        ?string $zipCode = null,
        ?string $city = null
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->addressCustomer = $address;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->rgpdAcceptedAt = new \DateTime();
        parent::__construct();
    }

    public static function create(?DeliveryDTO $dto)
    {
        return new self(
            $dto->getFirstname(),
            $dto->getName(),
            $dto->getEmail(),
            $dto->getPhoneNumber(),
            $dto->getAddress(),
            $dto->getZipCode(),
            $dto->getCity()
        );
    }

    public function getFullName()
    {
        return sprintf('%s %s', $this->firstname, $this->lastname);
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getRgpdAcceptedAt(): ?\DateTime
    {
        return $this->rgpdAcceptedAt;
    }

    public function getAddressCustomer(): ?string
    {
        return $this->addressCustomer;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
}
