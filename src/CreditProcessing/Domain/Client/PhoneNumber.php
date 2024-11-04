<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class PhoneNumber
{
    #[ORM\Column(type: 'string')]
    private readonly string $value;

    // Для демонстрации взял международный формат +1-XXX-XXX-XXXX
    public const PHONE_NUMBER_REGEX = '/^\+1-\d{3}-\d{3}-\d{4}$/';

    public function __construct(string $phoneNumber)
    {
        $this->validate($phoneNumber);
        $this->value = $phoneNumber;
    }

    private function validate(string $phoneNumber): void
    {
        if (!preg_match(self::PHONE_NUMBER_REGEX, $phoneNumber)) {
            throw new \InvalidArgumentException('Invalid phone number format. Expected format: +1-XXX-XXX-XXXX');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
