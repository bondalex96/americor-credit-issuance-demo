<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Credit\Specification\AndSpecification;
use App\CreditProcessing\Domain\Credit\Specification\Specification;
use PHPUnit\Framework\TestCase;

final class AndSpecificationTest extends TestCase
{
    public function testIsSatisfiedByAllTrue(): void
    {
        $specification1 = $this->createMock(Specification::class);
        $specification2 = $this->createMock(Specification::class);
        $client = $this->createMock(Client::class);

        $specification1->method('isSatisfiedBy')->willReturn(true);
        $specification2->method('isSatisfiedBy')->willReturn(true);

        $andSpecification = new AndSpecification($specification1, $specification2);

        $this->assertTrue($andSpecification->isSatisfiedBy($client));
    }

    public function testIsSatisfiedByOneFalse(): void
    {
        $specification1 = $this->createMock(Specification::class);
        $specification2 = $this->createMock(Specification::class);
        $client = $this->createMock(Client::class);

        $specification1->method('isSatisfiedBy')->willReturn(true);
        $specification2->method('isSatisfiedBy')->willReturn(false);

        $andSpecification = new AndSpecification($specification1, $specification2);

        $this->assertFalse($andSpecification->isSatisfiedBy($client));
    }

    public function testIsSatisfiedByAllFalse(): void
    {
        $specification1 = $this->createMock(Specification::class);
        $specification2 = $this->createMock(Specification::class);
        $client = $this->createMock(Client::class);

        $specification1->method('isSatisfiedBy')->willReturn(false);
        $specification2->method('isSatisfiedBy')->willReturn(false);

        $andSpecification = new AndSpecification($specification1, $specification2);

        $this->assertFalse($andSpecification->isSatisfiedBy($client));
    }
}
