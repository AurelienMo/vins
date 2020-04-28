<?php

namespace App\Admin\Delivery\Events;

use App\Entity\Delivery;
use Symfony\Contracts\EventDispatcher\Event;

class ConfirmDeliveryEvent extends Event
{
    /** @var string */
    protected $type;

    /** @var Delivery */
    protected $delivery;

    public function __construct(string $type, Delivery $delivery)
    {
        $this->type = $type;
        $this->delivery = $delivery;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Delivery
     */
    public function getDelivery(): Delivery
    {
        return $this->delivery;
    }

    public function getSubject(): string
    {
        $subject = 'Mon Premier Sommelier - ';
        switch ($this->type) {
            case Delivery::DELIVERED_AT_ADDRESS:
                $subject .= 'Livré à l\'adresse';
                break;
            case Delivery::DELIVERY_AT_VOISIN:
                $subject .= 'Livré chez un voisin';
                break;
            case Delivery::DELIVERY_MISS:
                $subject .= 'Personne absente';
                break;
        }

        return $subject;
    }

    public function getMainText()
    {
        switch ($this->type) {
            case Delivery::DELIVERED_AT_ADDRESS:
                return "Nous vous informons que nous avons bien livré votre commande à l'adresse indiquée lors de la commande.";
            case Delivery::DELIVERY_AT_VOISIN:
                return "Nous vous informons que nous avons déposé votre colis chez votre voisin comme indiqué sur votre commande.";
                break;
            case Delivery::DELIVERY_MISS:
                return "Malheureusement, nous n'avons pas pu vous livrer. Nous vous recontactons dans les plus brefs délais fin de planifier une nouvelle livraison";
                break;
        }
    }
}
