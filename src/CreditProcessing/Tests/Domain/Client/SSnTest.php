<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Client;

use App\CreditProcessing\Domain\Client\SSN;
use PHPUnit\Framework\TestCase;

final class SSnTest extends TestCase
{
    public function testWithValidSSN(): void
    {
        $ssn = new SSN('123-45-6789');
        $this->assertSame('123-45-6789', $ssn->getValue());
    }

    public function testWithInvalidSSN(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid SSN format. Expected format: XXX-XX-XXXX');
        new SSN('123-45-678');
    }
}
