<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Credit\Specification\AgeSpecification;
use App\CreditProcessing\Domain\Credit\Specification\AndSpecification;
use App\CreditProcessing\Domain\Credit\Specification\CreditScoreSpecification;
use App\CreditProcessing\Domain\Credit\Specification\IncomeSpecification;
use App\CreditProcessing\Domain\Credit\Specification\RandomRejectionSpecification;
use App\CreditProcessing\Domain\Credit\Specification\Specification;
use App\CreditProcessing\Domain\Credit\Specification\StateSpecification;

final class EligibilityChecker
{
    private Specification $specifications;

    public function __construct()
    {
        $this->specifications = new AndSpecification(
            new CreditScoreSpecification(),
            new IncomeSpecification(),
            new AgeSpecification(),
            new StateSpecification(),
            new RandomRejectionSpecification()
        );
    }

    public function checkIsEligible(Client $client): bool
    {
        return $this->specifications->isSatisfiedBy($client);
    }
}
