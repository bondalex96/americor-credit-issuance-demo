<?php

declare(strict_types=1);

namespace App\Api\Controller\V1\Credit\Issue;

use App\CreditProcessing\Domain\Credit\Product\DebtConsolidationCredit;
use App\CreditProcessing\Domain\Credit\Product\PersonalCredit;
use App\CreditProcessing\Domain\Credit\Product\StudentCredit;
use Symfony\Component\Validator\Constraints as Assert;

final class IssueCreditRequest
{
    public function __construct(
        #[Assert\NotBlank(message: 'Client ID is required.')]
        public readonly string $clientId,
        #[Assert\NotBlank(message: 'Product identifier is required.')]
        #[Assert\Choice(
            choices: [PersonalCredit::NAME, StudentCredit::NAME, DebtConsolidationCredit::NAME],
            message: 'Invalid product identifier.'
        )]
        public readonly string $product,
        #[Assert\NotBlank(message: 'Credit amount is required.')]
        #[Assert\Positive(message: 'Credit amount must be a positive number.')]
        public readonly float $amount,
        #[Assert\NotBlank(message: 'Credit term is required.')]
        #[Assert\Positive(message: 'Credit term must be a positive number.')]
        public readonly int $term,
    ) {
    }
}
