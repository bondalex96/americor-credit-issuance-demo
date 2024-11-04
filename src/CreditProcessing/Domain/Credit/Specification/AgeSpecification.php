<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;

final class AgeSpecification implements Specification
{
    private const MIN_ELIGIBILITY_AGE = 18;
    private const MAX_ELIGIBILITY_AGE = 60;

    public function isSatisfiedBy(Client $candidate): bool
    {
        return $candidate->isAgeInRange(self::MIN_ELIGIBILITY_AGE, self::MAX_ELIGIBILITY_AGE);
    }
}
