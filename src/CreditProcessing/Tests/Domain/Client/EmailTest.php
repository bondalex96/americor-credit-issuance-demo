<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Client;

use App\CreditProcessing\Domain\Client\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new Email('test@example.com');
        $this->assertSame('test@example.com', $email->getValue());
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email format');
        new Email('invalid-email');
    }
}
