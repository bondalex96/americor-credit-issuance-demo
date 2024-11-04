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

final class UpdatePersonalInfoTest extends TestCase
{
    private function initializeClient(): Client
    {
        $nameMock = $this->createMock(PersonName::class);
        $ageMock = $this->createMock(Age::class);
        $addressMock = $this->createMock(Address::class);
        $ssnMock = $this->createMock(SSN::class);
        $ficoScoreMock = $this->createMock(FICOScore::class);
        $emailMock = $this->createMock(Email::class);
        $phoneNumberMock = $this->createMock(PhoneNumber::class);
        $income = $this->createMock(MonthlyIncome::class);

        return new Client($nameMock, $ageMock, $addressMock, $ssnMock, $ficoScoreMock, $emailMock, $phoneNumberMock, $income);
    }

    public function testUpdatePersonalInfoUpdatesFieldsCorrectly(): void
    {
        $newNameMock = $this->createMock(PersonName::class);
        $newAgeMock = $this->createMock(Age::class);
        $newAddressMock = $this->createMock(Address::class);
        $newFicoScoreMock = $this->createMock(FICOScore::class);
        $newEmailMock = $this->createMock(Email::class);
        $newPhoneNumberMock = $this->createMock(PhoneNumber::class);
        $newIncome = $this->createMock(MonthlyIncome::class);

        $client = $this->initializeClient();
        $client->updatePersonalInfo($newNameMock, $newAgeMock, $newAddressMock, $newFicoScoreMock, $newEmailMock, $newPhoneNumberMock, $newIncome);

        self::assertSame($newNameMock, $client->getName());
        self::assertSame($newAgeMock, $client->getAge());
        self::assertSame($newAddressMock, $client->getAddress());
        self::assertSame($newFicoScoreMock, $client->getFicoScore());
        self::assertSame($newEmailMock, $client->getEmail());
        self::assertSame($newPhoneNumberMock, $client->getPhoneNumber());
        self::assertSame($newIncome, $client->getMonthlyIncome());
    }
}
