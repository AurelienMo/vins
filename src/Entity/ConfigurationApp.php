<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="amo_configuration_app")
 * @ORM\Entity()
 */
class ConfigurationApp extends AbstractEntity
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $deliveryOffer;

    /**
     * @return bool
     */
    public function isDeliveryOffer(): bool
    {
        return $this->deliveryOffer;
    }

    /**
     * @param bool $deliveryOffer
     */
    public function setDeliveryOffer(bool $deliveryOffer): void
    {
        $this->deliveryOffer = $deliveryOffer;
    }
}
