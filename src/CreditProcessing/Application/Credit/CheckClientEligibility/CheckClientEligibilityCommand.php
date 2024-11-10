<?php

declare(strict_types=1);

namespace App\CreditProcessing\Application\Credit\CheckClientEligibility;

final class CheckClientEligibilityCommand
{
    public function __construct(public readonly string $clientId)
    {
    }
}
