<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;

interface Specification
{
    public function isSatisfiedBy(Client $candidate): bool;
}
