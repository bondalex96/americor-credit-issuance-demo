<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Product;

final class PersonalCredit extends Product
{
    public const string NAME = 'personal';

    protected function getBaseInterestRate(): float
    {
        return 8;
    }
}
