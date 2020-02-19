<?php

declare(strict_types=1);

namespace App\Domain\Newsletter\Registration\Forms;

use Symfony\Component\Validator\Constraints as Assert;

class NewsletterRegistrationDTO
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
