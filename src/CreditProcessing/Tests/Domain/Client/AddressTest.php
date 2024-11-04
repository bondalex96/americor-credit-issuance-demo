<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Client;

use App\CreditProcessing\Domain\Client\Address;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    public function testWithValidAddress(): void
    {
        $address = new Address("New York, NY 10001");

        $this->assertEquals("New York", $address->getCity());
        $this->assertEquals("NY", $address->getState());
        $this->assertEquals("10001", $address->getZipCode());
    }
    public function testWithInvalidFormat(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid address format');

        new Address("Invalid Address Format");
    }

    public function testWithInvalidZipCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ZIP code format');

        new Address("New York, NY 123456");
    }

    public function testWithValidNotUSAAddress(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid state cod');
        new Address("25 King St, Sydney NSW 2000, Australia");
    }
}
