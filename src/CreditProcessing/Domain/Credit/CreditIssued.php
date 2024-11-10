<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit;

use App\Util\Domain\Model\Event;

final class CreditIssued implements Event
{
    public function __construct(
        public readonly string $creditId,
        public readonly string $clientName,
        public readonly string $clientPhone,
        public readonly string $clientEmail,
        public readonly float $creditAmount,
    ) {
    }
}
