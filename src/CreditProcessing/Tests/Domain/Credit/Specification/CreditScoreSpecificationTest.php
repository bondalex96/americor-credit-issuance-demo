<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Credit\Specification\CreditScoreSpecification;
use PHPUnit\Framework\TestCase;

final class CreditScoreSpecificationTest extends TestCase
{
    public function testIsSatisfiedByEligibleScore(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('isFicoScoreGreaterThan')->with(500)->willReturn(true);

        $creditScoreSpecification = new CreditScoreSpecification();

        $this->assertTrue($creditScoreSpecification->isSatisfiedBy($client));
    }

    public function testIsSatisfiedByIneligibleScore(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('isFicoScoreGreaterThan')->with(500)->willReturn(false);

        $creditScoreSpecification = new CreditScoreSpecification();

        $this->assertFalse($creditScoreSpecification->isSatisfiedBy($client));
    }
}
