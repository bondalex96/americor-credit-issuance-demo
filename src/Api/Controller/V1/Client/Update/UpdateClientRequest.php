<?php

declare(strict_types=1);

namespace App\Api\Controller\V1\Client\Update;

use App\CreditProcessing\Domain\Client\PhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;

final class UpdateClientRequest
{
    public function __construct(
        #[Assert\NotBlank(message: 'This value should not be blank.')]
        public readonly string $lastName,
        #[Assert\NotBlank(message: 'This value should not be blank.')]
        public readonly string $firstName,
        #[Assert\NotBlank(message: 'This value should not be blank.')]
        #[Assert\Positive(message: 'This value should be positive.')]
        public readonly int $age,
        #[Assert\NotBlank(message: 'This value should not be blank.')]
        public readonly string $address,
        #[Assert\NotBlank(message: 'This value should not be blank.')]
        public readonly int $fico,
        #[Assert\NotBlank(message: 'This value should not be blank.')]
        #[Assert\Email(message: 'This value is not a valid email address.')]
        public readonly string $email,
        #[Assert\NotBlank(message: 'This value should not be blank.')]
        #[Assert\Regex(pattern: PhoneNumber::PHONE_NUMBER_REGEX, message: 'This value is not valid.')]
        public readonly string $phoneNumber,
        #[Assert\NotBlank(message: 'This value should not be blank.')]
        #[Assert\Positive(message: 'This value should be positive.')]
        public readonly float $monthlyIncome,
    ) {
    }
}
