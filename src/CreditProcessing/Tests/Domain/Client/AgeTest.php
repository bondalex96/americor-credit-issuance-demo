<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Client;

use App\CreditProcessing\Domain\Client\Age;
use PHPUnit\Framework\TestCase;

final class AgeTest extends TestCase
{
    public function testValidAge(): void
    {
        $age = new Age(25);
        self::assertInstanceOf(Age::class, $age);
    }

    public function testAgeIsZeroThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $age = new Age(0);
    }

    public function testNegativeAgeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $age = new Age(-5);
    }
}
