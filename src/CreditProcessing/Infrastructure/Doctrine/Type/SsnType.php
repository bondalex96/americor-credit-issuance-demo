<?php

declare(strict_types=1);

namespace App\CreditProcessing\Infrastructure\Doctrine\Type;

use App\CreditProcessing\Domain\Client\SSN;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class SsnType extends Type
{
    const NAME = 'ssn';

    public function getSQLDeclaration(
        array $column,
        AbstractPlatform $platform
    ): string {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): SSN
    {
        return new SSN($value);
    }

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ): string {

        return (string)$value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
