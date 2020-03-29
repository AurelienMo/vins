<?php

declare(strict_types=1);

namespace App\Domain\Contact\Events;

use App\Entity\Contact;

class ContactMailEvent
{
    /** @var Contact */
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}
