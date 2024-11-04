<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

use App\Util\Domain\Validation\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Email
{
    #[ORM\Column(type: 'string')]
    private readonly string $value;

    public function __construct(string $email)
    {
        Assert::email($email, 'Invalid email format');
        $this->value = $email;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
