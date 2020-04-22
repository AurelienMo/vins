<?php

declare(strict_types=1);

namespace App\Domain\Cart\Delivery\Forms;

use App\Entity\NicheOfDelivery;
use Symfony\Component\Validator\Constraints as Assert;

class DeliveryDTO
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^(([1][3][0])|(9[0]))[0-9]{2}$/",
     *     message="Code postal sur Marseille attendu"
     * )
     */
    protected $zipCode;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string|null
     */
    protected $comment;

    /**
     * @var string
     */
    protected $typeDelivery;

    /**
     * @var NicheOfDelivery
     */
    protected $deliveryNiche;

    /**
     * @var string|null
     */
    protected $personIfAbsent;

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getTypeDelivery()
    {
        return $this->typeDelivery;
    }

    public function setTypeDelivery(string $typeDelivery): void
    {
        $this->typeDelivery = $typeDelivery;
    }

    public function getDeliveryNiche()
    {
        return $this->deliveryNiche;
    }

    public function setDeliveryNiche(?NicheOfDelivery $deliveryNiche): void
    {
        $this->deliveryNiche = $deliveryNiche;
    }

    public function getPersonIfAbsent()
    {
        return $this->personIfAbsent;
    }

    public function setPersonIfAbsent(?string $personIfAbsent): void
    {
        $this->personIfAbsent = $personIfAbsent;
    }
}
