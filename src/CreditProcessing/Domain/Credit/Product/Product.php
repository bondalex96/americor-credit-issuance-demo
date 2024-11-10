<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Product;

use App\CreditProcessing\Domain\Client\Client;

abstract class Product
{
    public const string NAME = '';

    private const INTEREST_RATE_INCREMENT_FOR_CA = 11.49;

    public function calculateInterestRate(Client $client): float
    {
        $interestRate = $this->getBaseInterestRate();

        if ($client->checkIsFromCA()) {
            $interestRate += self::INTEREST_RATE_INCREMENT_FOR_CA;
        }

        return round($interestRate, 2);
    }

    abstract protected function getBaseInterestRate(): float;

    public function getName(): string
    {
        return self::NAME;
    }
}
