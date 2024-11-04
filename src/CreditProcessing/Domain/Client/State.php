<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

final readonly class State
{
    public const CA = 'CA';
    public const NY = 'NY';
    public const NV = 'NV';

    public const USA_STATES = [
        'AL',
        'AK',
        'AZ',
        'AR',
        self::CA,
        'CO',
        'CT',
        'DE',
        'FL',
        'GA',
        'HI',
        'ID',
        'IL',
        'IN',
        'IA',
        'KS',
        'KY',
        'LA',
        'ME',
        'MD',
        'MA',
        'MI',
        'MN',
        'MS',
        'MO',
        'MT',
        'NE',
        self::NV,
        'NH',
        'NJ',
        'NM',
        self::NY,
        'NC',
        'ND',
        'OH',
        'OK',
        'OR',
        'PA',
        'RI',
        'SC',
        'SD',
        'TN',
        'TX',
        'UT',
        'VT',
        'VA',
        'WA',
        'WV',
        'WI',
        'WY'
    ];

    public static function validateState(string $state): void
    {
        if (!in_array($state, self::USA_STATES)) {
            throw new \InvalidArgumentException('Invalid state code');
        }
    }
}
