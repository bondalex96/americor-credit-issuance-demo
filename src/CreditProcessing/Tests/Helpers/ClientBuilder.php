<?php

declare(strict_types=1);

namespace Helpers;

use App\CreditProcessing\Domain\Client\Address;
use App\CreditProcessing\Domain\Client\Age;
use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Client\Email;
use App\CreditProcessing\Domain\Client\FICOScore;
use App\CreditProcessing\Domain\Client\MonthlyIncome;
use App\CreditProcessing\Domain\Client\PersonName;
use App\CreditProcessing\Domain\Client\PhoneNumber;
use App\CreditProcessing\Domain\Client\SSN;

final class ClientBuilder
{
    private SSN $ssn;
    private PersonName $name;
    private Age $age;
    private Address $address;
    private FICOScore $ficoScore;
    private Email $email;
    private PhoneNumber $phoneNumber;
    private MonthlyIncome $monthlyIncome;

    public function __construct()
    {
        $this->ssn = new SSN('123-45-6789');
        $this->name = new PersonName('John', 'Doe');
        $this->age = new Age(30);
        $this->address = new Address('Los Angeles, CA 90001');
        $this->ficoScore = new FICOScore(700);
        $this->email = new Email('johndoe@example.com');
        $this->phoneNumber = new PhoneNumber('+1-123-456-7890');
        $this->monthlyIncome = MonthlyIncome::fromUSD(5000);
    }

    public function withSSN(string $ssn): self
    {
        $clone = clone $this;
        $clone->ssn = new SSN($ssn);
        return $clone;
    }

    public function withName(string $firstName, string $lastName): self
    {
        $clone = clone $this;
        $clone->name = new PersonName($firstName, $lastName);
        return $clone;
    }

    public function withAge(int $age): self
    {
        $clone = clone $this;
        $clone->age = new Age($age);
        return $clone;
    }

    public function withAddress(string $address): self
    {
        $clone = clone $this;
        $clone->address = new Address($address);
        return $clone;
    }

    public function withFICOScore(int $score): self
    {
        $clone = clone $this;
        $clone->ficoScore = new FICOScore($score);
        return $clone;
    }

    public function withEmail(string $email): self
    {
        $clone = clone $this;
        $clone->email = new Email($email);
        return $clone;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $clone = clone $this;
        $clone->phoneNumber = new PhoneNumber($phoneNumber);
        return $clone;
    }

    public function withMonthlyIncome(float $incomeInDollars): self
    {
        $clone = clone $this;
        $clone->monthlyIncome = MonthlyIncome::fromUSD($incomeInDollars);
        return $clone;
    }

    public function build(): Client
    {
        return new Client(
            name: $this->name,
            age: $this->age,
            address: $this->address,
            ssn: $this->ssn,
            ficoScore: $this->ficoScore,
            email: $this->email,
            phoneNumber: $this->phoneNumber,
            monthlyIncome: $this->monthlyIncome
        );
    }
}
