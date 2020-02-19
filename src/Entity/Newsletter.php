<?php

declare(strict_types=1);

namespace App\Entity;

use App\Domain\Newsletter\Registration\Forms\NewsletterRegistrationDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="amo_newsletter")
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterRepository")
 */
class Newsletter extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $email;

    public function __construct(string $email)
    {
        $this->email = $email;
        parent::__construct();
    }

    public static function createFromDto(NewsletterRegistrationDTO $dto)
    {
        return new self($dto->getEmail());
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
