<?php

declare(strict_types=1);

namespace App\CreditProcessing\Application\Credit\Issue;

final class IssueCreditCommand
{
    public function __construct(
        public readonly string $clientId,
        public readonly string $product,
        public readonly float $amount,
        public readonly int $term,
    ) {
    }
}
