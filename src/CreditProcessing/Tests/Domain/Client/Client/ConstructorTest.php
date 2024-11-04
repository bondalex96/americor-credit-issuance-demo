<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Client\Client;

use App\CreditProcessing\Domain\Client\Address;
use App\CreditProcessing\Domain\Client\Age;
use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Client\Email;
use App\CreditProcessing\Domain\Client\FICOScore;
use App\CreditProcessing\Domain\Client\MonthlyIncome;
use App\CreditProcessing\Domain\Client\PersonName;
use App\CreditProcessing\Domain\Client\PhoneNumber;
use App\CreditProcessing\Domain\Client\SSN;
use PHPUnit\Framework\TestCase;

final class ConstructorTest extends TestCase
{
    public function testConstructorInitializesPropertiesCorrectly(): void
    {
        $name = $this->createMock(PersonName::class);
        $age = $this->createMock(Age::class);
        $address = $this->createMock(Address::class);
        $ssn = $this->createMock(SSN::class);
        $ficoScore = $this->createMock(FICOScore::class);
        $email = $this->createMock(Email::class);
        $phoneNumber = $this->createMock(PhoneNumber::class);
        $income = $this->createMock(MonthlyIncome::class);

        $client = new Client($name, $age, $address, $ssn, $ficoScore, $email, $phoneNumber, $income);

        self::assertSame($name, $client->getName());
        self::assertSame($age, $client->getAge());
        self::assertSame($address, $client->getAddress());
        self::assertSame($ssn, $client->getId());
        self::assertSame($ficoScore, $client->getFicoScore());
        self::assertSame($email, $client->getEmail());
        self::assertSame($phoneNumber, $client->getPhoneNumber());
        self::assertSame($income, $client->getMonthlyIncome());
    }
}
