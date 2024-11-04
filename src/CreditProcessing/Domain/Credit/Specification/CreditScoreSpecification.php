<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;

final class CreditScoreSpecification implements Specification
{
    private const MIN_ELIGIBILITY_FICO_SCORE = 500;

    public function isSatisfiedBy(Client $candidate): bool
    {
        return $candidate->isFicoScoreGreaterThan(self::MIN_ELIGIBILITY_FICO_SCORE);
    }
}
