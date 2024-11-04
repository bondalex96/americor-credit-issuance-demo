<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit\Specification;

use App\CreditProcessing\Domain\Client\Client;

class RandomRejectionSpecification implements Specification
{
    public function isSatisfiedBy(Client $candidate): bool
    {
        if (!$candidate->isFromNY()) {
            return true;
        }

        return $this->shouldRejectWith50PercentProbability();
    }

    private function shouldRejectWith50PercentProbability(): bool
    {
        return mt_rand(0, 1) === 1;
    }
}
