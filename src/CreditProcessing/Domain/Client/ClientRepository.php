<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

interface ClientRepository
{
    public function findById(string $id): ?Client;

    public function getById(string $id): Client;

    public function save(Client $client): void;
}
