<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

class SSN
{
    public const SSN_REGEX = '/^\d{3}-\d{2}-\d{4}$/';
    private readonly string $value;

    public function __construct(string $ssn)
    {
        $this->validate($ssn);
        $this->value = $ssn;
    }

    private function validate(string $ssn): void
    {
        if (!preg_match(self::SSN_REGEX, $ssn)) {
            throw new \InvalidArgumentException('Invalid SSN format. Expected format: XXX-XX-XXXX');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
