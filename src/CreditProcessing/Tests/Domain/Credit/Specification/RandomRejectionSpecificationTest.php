<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Credit\Specification\RandomRejectionSpecification;
use PHPUnit\Framework\TestCase;

final class RandomRejectionSpecificationTest extends TestCase
{
    public function testIsSatisfiedByClientNotFromNY(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('isFromNY')->willReturn(false);

        $randomRejectionSpecification = new RandomRejectionSpecification();

        $this->assertTrue($randomRejectionSpecification->isSatisfiedBy($client));
    }

    public function testIsSatisfiedByClientFromNYWithProbability(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('isFromNY')->willReturn(true);

        $randomRejectionSpecification = new RandomRejectionSpecification();

        $trueCount = 0;
        $falseCount = 0;

        // Test 1000 times to get a sense of the probabilistic outcome
        for ($i = 0; $i < 1000; $i++) {
            if ($randomRejectionSpecification->isSatisfiedBy($client)) {
                $trueCount++;
            } else {
                $falseCount++;
            }
        }

        // We expect roughly 50-50 distribution due to random nature
        $this->assertGreaterThanOrEqual(400, $trueCount, 'Expected more than 400 true outcomes due to probability.');
        $this->assertGreaterThanOrEqual(400, $falseCount, 'Expected more than 400 false outcomes due to probability.');
    }
}
