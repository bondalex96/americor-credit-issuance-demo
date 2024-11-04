<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Address
{
    #[ORM\Column(type: 'string')]
    private readonly string $city;

    #[ORM\Column(type: 'string', length: 2)]
    private readonly string $state;

    #[ORM\Column(type: 'string')]
    private readonly string $zipCode;

    // Format: "City, State ZIP"
    private const ADDRESS_REGEX = '/^(.+),\s*([A-Z]{2})\s*(.+)$/i';
    //
    private const ZIP_CODE_REGEX = '/^\d{5}(-\d{4})?$/';

    public function __construct(string $address)
    {
        [$city, $state, $zipCode] = $this->parseAddress($address);

        $this->validateState($state);
        $this->validateZipCode($zipCode);

        $this->city = trim($city);
        $this->state = strtoupper(trim($state));
        $this->zipCode = $zipCode;
    }

    private function parseAddress(string $address): array
    {
        if (preg_match(self::ADDRESS_REGEX, $address, $matches)) {
            return [$matches[1], $matches[2], $matches[3]];
        }

        throw new \InvalidArgumentException('Invalid address format');
    }

    private function validateState(string $state): void
    {
        State::validateState($state);
    }

    private function validateZipCode(string $zipCode): void
    {
        if (!preg_match(self::ZIP_CODE_REGEX, $zipCode)) {
            throw new \InvalidArgumentException('Invalid ZIP code format');
        }
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }
}
