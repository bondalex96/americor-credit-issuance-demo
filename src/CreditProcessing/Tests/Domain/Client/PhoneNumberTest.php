<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Client;

use App\CreditProcessing\Domain\Client\PhoneNumber;
use PHPUnit\Framework\TestCase;

final class PhoneNumberTest extends TestCase
{
    public function testValidPhoneNumber(): void
    {
        $phoneNumber = new PhoneNumber('+1-123-456-7890');
        $this->assertSame('+1-123-456-7890', $phoneNumber->getValue());
    }
    /**
     * @dataProvider invalidPhoneNumberProvider
     */
    public function testInvalidPhoneNumberThrowsException(string $invalidPhoneNumber): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid phone number format. Expected format: +1-XXX-XXX-XXXX');

        new PhoneNumber($invalidPhoneNumber); // Неправильный формат
    }

    public function invalidPhoneNumberProvider(): array
    {
        return [
            ['123-456-7890'],          // Нет международного кода
            ['+1-123-4567-890'],       // Неправильный формат (слишком много цифр в третьем блоке)
            ['+1-1234-56-7890'],       // Неправильный формат (слишком много цифр в первом блоке)
            ['+1-123-456-78'],         // Неправильный формат (слишком мало цифр)
            ['+1-123-456-78901'],      // Неправильный формат (слишком много цифр)
            ['+44-123-456-7890'],      // Другой международный код
            ['+1 123 456 7890'],       // Использование пробелов вместо дефисов
            ['+1.123.456.7890'],       // Использование точек вместо дефисов
            ['+1-123-45A-7890'],       // Наличие букв
            ['+1-123-456-78!0'],       // Наличие специальных символов
        ];
    }
}
