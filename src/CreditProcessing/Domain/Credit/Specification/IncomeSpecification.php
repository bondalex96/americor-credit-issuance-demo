<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Client\MonthlyIncome;

final class IncomeSpecification implements Specification
{
    private const MIN_ELIGIBLE_INCOME = 1000;

    public function isSatisfiedBy(Client $candidate): bool
    {
        return $candidate->isIncomeGreaterThan(MonthlyIncome::fromUSD(self::MIN_ELIGIBLE_INCOME));
    }
}
