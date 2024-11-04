<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class MonthlyIncome
{
    #[ORM\Column(type: 'integer')]
    private int $amount;

    #[ORM\Column(type: 'string', length: 3)]
    private string $currency;

    public const CURRENCY_USD = 'USD';

    private function __construct(int $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function fromUSD(float $amount): MonthlyIncome
    {
        $amountInCents = (int)round($amount * 100);
        return new self($amountInCents, self::CURRENCY_USD);
    }

    public function getAmountInDollars(): float
    {
        return $this->amount / 100.0;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function greaterThan(MonthlyIncome $other): bool
    {
        return $this->amount > $other->amount;
    }
}
