<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Client\MonthlyIncome;
use App\CreditProcessing\Domain\Credit\Specification\IncomeSpecification;
use PHPUnit\Framework\TestCase;

final class IncomeSpecificationTest extends TestCase
{
    public function testIsSatisfiedByEligibleIncome(): void
    {

        $client = $this->createMock(Client::class);
        $client->method('isIncomeGreaterThan')->with(MonthlyIncome::fromUSD(1000))->willReturn(true);

        $incomeSpecification = new IncomeSpecification();

        $this->assertTrue($incomeSpecification->isSatisfiedBy($client));
    }

    public function testIsSatisfiedByIneligibleIncome(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('isIncomeGreaterThan')->with(MonthlyIncome::fromUSD(1000))->willReturn(false);

        $incomeSpecification = new IncomeSpecification();

        $this->assertFalse($incomeSpecification->isSatisfiedBy($client));
    }
}
