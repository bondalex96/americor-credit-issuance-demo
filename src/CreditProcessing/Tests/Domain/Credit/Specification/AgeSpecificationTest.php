<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Credit\Specification\AgeSpecification;
use PHPUnit\Framework\TestCase;

final class AgeSpecificationTest extends TestCase
{
    public function testIsSatisfiedByWithinRange(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('isAgeInRange')->willReturn(true);

        $ageSpecification = new AgeSpecification();

        $this->assertTrue($ageSpecification->isSatisfiedBy($client));
    }

    public function testIsSatisfiedByBelowRange(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('isAgeInRange')->willReturn(false);

        $ageSpecification = new AgeSpecification();

        $this->assertFalse($ageSpecification->isSatisfiedBy($client));
    }

    public function testIsSatisfiedByAboveRange(): void
    {
        $client = $this->createMock(Client::class);
        $client->method('isAgeInRange')->willReturn(false);

        $ageSpecification = new AgeSpecification();

        $this->assertFalse($ageSpecification->isSatisfiedBy($client));
    }
}
