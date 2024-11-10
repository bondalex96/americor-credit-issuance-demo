<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Product;

final class StudentCredit extends Product
{
    public const string NAME = 'student';

    protected function getBaseInterestRate(): float
    {
        return 6;
    }
}
