<?php

declare(strict_types=1);

namespace App\CreditProcessing\Application\Client\Update;

use App\CreditProcessing\Domain\Client\Address;
use App\CreditProcessing\Domain\Client\Age;
use App\CreditProcessing\Domain\Client\ClientRepository;
use App\CreditProcessing\Domain\Client\Email;
use App\CreditProcessing\Domain\Client\FICOScore;
use App\CreditProcessing\Domain\Client\MonthlyIncome;
use App\CreditProcessing\Domain\Client\PersonName;
use App\CreditProcessing\Domain\Client\PhoneNumber;
use DomainException;

final class UpdateClientHandler
{
    public function __construct(private readonly ClientRepository $clientRepository)
    {
    }

    public function handle(UpdateClientCommand $command): void
    {
        $client = $this->clientRepository->findById($command->ssn);

        if (!$client) {
            throw new DomainException('Client with this SSN does not exist.');
        }

        $client->updatePersonalInfo(
            name: new PersonName($command->firstName, $command->lastName),
            age: new Age($command->age),
            address: new Address($command->address),
            ficoScore: new FICOScore($command->fico),
            email: new Email($command->email),
            phoneNumber: new PhoneNumber($command->phoneNumber),
            monthlyIncome: MonthlyIncome::fromUSD($command->monthlyIncome),
        );

        $this->clientRepository->save($client);
    }
}
