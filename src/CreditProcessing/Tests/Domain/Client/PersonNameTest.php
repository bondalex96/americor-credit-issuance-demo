<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Client;

use App\CreditProcessing\Domain\Client\PersonName;
use PHPUnit\Framework\TestCase;

final class PersonNameTest extends TestCase
{
    public function testCreatesValidPersonName(): void
    {
        $personName = new PersonName('John', 'Doe');

        self::assertEquals('John', $personName->getFirstName());
        self::assertEquals('Doe', $personName->getLastName());
        self::assertEquals('John Doe', $personName->getFullName());
    }

    /**
     * @test
     */
    public function testTrimsWhitespaceFromNames(): void
    {
        $personName = new PersonName('  John  ', '  Doe  ');

        self::assertEquals('John', $personName->getFirstName());
        self::assertEquals('Doe', $personName->getLastName());
        self::assertEquals('John Doe', $personName->getFullName());
    }

    /**
     * @test
     * @dataProvider invalidFirstNamesProvider
     */
    public function testThrowsExceptionForInvalidFirstNames(string $firstName, string $lastName): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('First name cannot be empty');

        new PersonName($firstName, $lastName);
    }

    /**
     * @test
     * @dataProvider invalidLastNamesProvider
     */
    public function testThrowsExceptionForInvalidLastNames(string $firstName, string $lastName): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Last name cannot be empty');

        new PersonName($firstName, $lastName);
    }

    /**
     * @test
     */
    public function testPreservesCaseSensitivity(): void
    {
        $personName = new PersonName('John', 'McDowell');

        self::assertEquals('John', $personName->getFirstName());
        self::assertEquals('McDowell', $personName->getLastName());
        self::assertEquals('John McDowell', $personName->getFullName());
    }

    /**
     * Data Provider for invalid first names
     */
    public function invalidFirstNamesProvider(): array
    {
        return [
            'empty first name' => ['', 'Doe'],
            'whitespace first name' => ['   ', 'Doe'],
        ];
    }

    /**
     * Data Provider for invalid last names
     */
    public function invalidLastNamesProvider(): array
    {
        return [
            'empty last name' => ['John', ''],
            'whitespace last name' => ['John', '   '],
        ];
    }
}
