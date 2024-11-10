<?php

declare(strict_types=1);

namespace App\CreditProcessing\Infrastructure\Repository\Doctrine;

use App\CreditProcessing\Domain\Credit\CreditApplication;
use App\CreditProcessing\Domain\Credit\CreditApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineCreditApplicationRepository implements CreditApplicationRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(CreditApplication $credit): void
    {
        $this->entityManager->persist($credit);
        $this->entityManager->flush();
    }
}
