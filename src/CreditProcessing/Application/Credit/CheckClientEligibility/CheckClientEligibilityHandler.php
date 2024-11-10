<?php

declare(strict_types=1);

namespace App\CreditProcessing\Application\Credit\CheckClientEligibility;

use App\CreditProcessing\Domain\Client\ClientRepository;
use App\CreditProcessing\Domain\Credit\EligibilityChecker;

final class CheckClientEligibilityHandler
{
    public function __construct(
        private readonly EligibilityChecker $checker,
        private readonly ClientRepository $clientRepository
    ) {
    }

    public function handle(CheckClientEligibilityCommand $command): bool
    {
        $client = $this->clientRepository->getById($command->clientId);
        return $this->checker->checkIsEligible($client);
    }
}
