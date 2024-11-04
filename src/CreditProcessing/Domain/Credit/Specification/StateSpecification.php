<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Client\State;

final class StateSpecification implements Specification
{
    private array $allowedStates = [State::CA, State::NY, State::NV];

    public function isSatisfiedBy(Client $candidate): bool
    {
        return $candidate->checkIsFromOneOfStates($this->allowedStates);
    }
}
