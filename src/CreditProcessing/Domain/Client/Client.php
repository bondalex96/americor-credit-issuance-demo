<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Client
{
    #[ORM\Id]
    #[ORM\Column(type: 'ssn', unique: true)]
    private SSN $id;

    #[ORM\Embedded(class: PersonName::class)]
    private PersonName $name;

    #[ORM\Embedded(class: Age::class)]
    private Age $age;

    #[ORM\Embedded(class: Address::class)]
    private Address $address;

    #[ORM\Embedded(class: FICOScore::class)]
    private FICOScore $ficoScore;

    #[ORM\Embedded(class: Email::class)]
    private Email $email;

    #[ORM\Embedded(class: PhoneNumber::class)]
    private PhoneNumber $phoneNumber;

    #[ORM\Embedded(class: MonthlyIncome::class)]
    private MonthlyIncome $monthlyIncome;

    public function __construct(
        PersonName $name,
        Age $age,
        Address $address,
        SSN $ssn,
        FICOScore $ficoScore,
        Email $email,
        PhoneNumber $phoneNumber,
        MonthlyIncome $monthlyIncome,
    ) {
        $this->id = $ssn;
        $this->name = $name;
        $this->age = $age;
        $this->address = $address;
        $this->ficoScore = $ficoScore;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->monthlyIncome = $monthlyIncome;
    }

    public function updatePersonalInfo(
        PersonName $name,
        Age $age,
        Address $address,
        FICOScore $ficoScore,
        Email $email,
        PhoneNumber $phoneNumber,
        MonthlyIncome $monthlyIncome,
    ): void {
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->age = $age;
        $this->address = $address;
        $this->ficoScore = $ficoScore;
        $this->monthlyIncome = $monthlyIncome;
    }

    public function getId(): SSN
    {
        return $this->id;
    }

    public function getName(): PersonName
    {
        return $this->name;
    }

    public function getAge(): Age
    {
        return $this->age;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getFicoScore(): FICOScore
    {
        return $this->ficoScore;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function getMonthlyIncome(): MonthlyIncome
    {
        return $this->monthlyIncome;
    }

    public function isFromNY(): bool
    {
        return $this->address->getState() === State::NY;
    }

    public function checkIsFromOneOfStates(array $states): bool
    {
        return in_array($this->address->getState(), $states);
    }

    public function checkIsFromCA(): bool
    {
        return $this->checkIsFromOneOfStates([State::CA]);
    }

    public function isAgeInRange(int $min, int $max): bool
    {
        return $this->age->getValue() >= $min && $this->age->getValue() <= $max;
    }

    public function isFicoScoreGreaterThan(int $score): bool
    {
        return $this->ficoScore->getScore() > $score;
    }


    public function isIncomeGreaterThan(MonthlyIncome $money): bool
    {
        return $this->monthlyIncome->greaterThan($money);
    }
}
