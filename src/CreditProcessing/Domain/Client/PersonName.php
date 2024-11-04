<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

use App\Util\Domain\Validation\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class PersonName
{
    #[ORM\Column(type: 'string')]
    private string $firstName;

    #[ORM\Column(type: 'string')]
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $firstName = trim($firstName);
        $lastName = trim($lastName);

        Assert::stringNotEmpty($firstName, 'First name cannot be empty');
        Assert::stringNotEmpty($lastName, 'Last name cannot be empty');

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}
