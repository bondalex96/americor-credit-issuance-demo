<?php

declare(strict_types=1);

namespace App\CreditProcessing\Application\Credit\Issue;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Client\ClientRepository;
use App\CreditProcessing\Domain\Credit\CreditApplication;
use App\CreditProcessing\Domain\Credit\CreditApplicationRepository;
use App\CreditProcessing\Domain\Credit\EligibilityChecker;
use App\CreditProcessing\Domain\Credit\Product\ProductRepository;
use App\Util\Domain\EventDispatcher\EventDispatcher;

final readonly class IssueCreditHandler
{
    public function __construct(
        private ClientRepository $clientRepository,
        private CreditApplicationRepository $creditRepository,
        private EligibilityChecker $eligibilityChecker,
        private ProductRepository $productRepository,
        private EventDispatcher $eventDispatcher,
    ) {
    }
    public function handle(IssueCreditCommand $command): CreditReadModel
    {
        $client = $this->clientRepository->getById($command->clientId);

        $product = $this->productRepository->getProduct($command->product);

        $credit = CreditApplication::issue(
            client: $client,
            product: $product,
            eligibilityChecker: $this->eligibilityChecker,
            term: $command->term,
            amount: $command->amount,
        );

        $this->creditRepository->save($credit);

        $this->eventDispatcher->dispatch($credit->releaseEvents());

        return new CreditReadModel(
            (string)$credit->getId(),
            $credit->getInterestRate(),
            $credit->getAmount(),
            $credit->getTerm()
        );
    }
}
