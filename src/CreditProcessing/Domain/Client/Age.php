<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

use App\Util\Domain\Validation\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Age
{
    #[ORM\Column(type: 'integer')]
    private readonly int $value;

    public function __construct(int $value)
    {
        Assert::greaterThan($value, 0, 'Age cannot be less than 0');
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
