<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Product;

final class DebtConsolidationCredit extends Product
{
    public const string NAME = 'debt_consolidation';

    protected function getBaseInterestRate(): float
    {
        return 10;
    }
}
