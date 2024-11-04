<?php

declare(strict_types=1);

namespace Domain\Client;

use App\CreditProcessing\Domain\Client\MonthlyIncome;
use PHPUnit\Framework\TestCase;

final class MonthlyIncomeTests extends TestCase
{
    public function testFromUSD(): void
    {
        $money = MonthlyIncome::fromUSD(10.75);
        $this->assertInstanceOf(MonthlyIncome::class, $money);
        $this->assertEquals(10.75, $money->getAmountInDollars());
        $this->assertEquals(MonthlyIncome::CURRENCY_USD, $money->getCurrency());
    }

    public function testGetAmountInDollars(): void
    {
        $money = MonthlyIncome::fromUSD(20.50);
        $this->assertEquals(20.50, $money->getAmountInDollars());
    }

    public function testGetCurrency(): void
    {
        $money = MonthlyIncome::fromUSD(5.00);
        $this->assertEquals(MonthlyIncome::CURRENCY_USD, $money->getCurrency());
    }

    public function testGreaterThan(): void
    {
        $money1 = MonthlyIncome::fromUSD(15.75);
        $money2 = MonthlyIncome::fromUSD(10.50);

        $this->assertTrue($money1->greaterThan($money2));
        $this->assertFalse($money2->greaterThan($money1));
    }
}
