<?php

declare(strict_types=1);

namespace App\CreditProcessing\Application\Client\Update;

final class UpdateClientCommand
{
    public function __construct(
        public readonly string $ssn,
        public readonly string $lastName,
        public readonly string $firstName,
        public readonly int $age,
        public readonly string $address,
        public readonly int $fico,
        public readonly string $email,
        public readonly string $phoneNumber,
        public readonly float $monthlyIncome
    ) {
    }
}
