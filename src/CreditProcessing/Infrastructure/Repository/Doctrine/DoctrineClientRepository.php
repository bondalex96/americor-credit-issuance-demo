<?php

declare(strict_types=1);

namespace App\CreditProcessing\Infrastructure\Repository\Doctrine;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Client\ClientRepository;
use App\Util\Domain\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class DoctrineClientRepository implements ClientRepository
{
    private ObjectRepository $entityRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityRepository = $entityManager->getRepository(Client::class);
    }

    public function findById(string $id): ?Client
    {
        return $this->entityRepository->find($id);
    }

    public function getById(string $id): Client
    {
        $client = $this->findById($id);

        if (!$client) {
            throw new NotFoundException('Client with id ' . $id . ' not found');
        }

        return $client;
    }

    public function save(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}
