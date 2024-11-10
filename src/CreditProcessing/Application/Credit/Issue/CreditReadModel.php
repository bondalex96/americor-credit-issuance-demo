<?php

declare(strict_types=1);

namespace App\CreditProcessing\Application\Credit\Issue;

final class CreditReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly float $interestRate,
        public readonly float $amount,
        public readonly int $term,
    ) {
    }
}
