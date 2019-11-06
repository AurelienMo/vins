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

use App\Entity\Embedded\Address;
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
    protected $civility;

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
     * @var Address
     *
     * @ORM\Embedded(class="App\Entity\Embedded\Address")
     */
    protected $address;

    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean")
     */
    protected $rgpdOk;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $rgpdAcceptedAt;

    public function __construct()
    {
        $this->address = new Address();
        parent::__construct();
    }

    public function getFullName()
    {
        return sprintf('%s %s', $this->firstname, $this->lastname);
    }

    /**
     * @return string|null
     */
    public function getCivility(): ?string
    {
        return $this->civility;
    }

    /**
     * @param string|null $civility
     */
    public function setCivility(?string $civility): void
    {
        $this->civility = $civility;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return \DateTime|null
     */
    public function getRgpdAcceptedAt(): ?\DateTime
    {
        return $this->rgpdAcceptedAt;
    }

    /**
     * @param \DateTime|null $rgpdAcceptedAt
     */
    public function setRgpdAcceptedAt(?\DateTime $rgpdAcceptedAt): void
    {
        $this->rgpdAcceptedAt = $rgpdAcceptedAt;
    }

    /**
     * @return bool|null
     */
    public function getRgpdOk(): ?bool
    {
        return $this->rgpdOk;
    }

    /**
     * @param bool|null $rgpdOk
     */
    public function setRgpdOk(?bool $rgpdOk): void
    {
        $this->rgpdOk = $rgpdOk;
    }
}
