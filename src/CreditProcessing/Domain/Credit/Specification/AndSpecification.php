<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;

final class AndSpecification implements Specification
{
    private array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(Client $candidate): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($candidate)) {
                return false;
            }
        }
        return true;
    }
}
