<?php

declare(strict_types=1);

namespace CreditProcessing\Infrastructure\EventListener;

use App\CreditProcessing\Domain\Credit\CreditIssued;
use Psr\Log\LoggerInterface;

final class EmailNotificationListener
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    public function onCreditIssued(CreditIssued $event): void
    {

        $message = "Dear {$event->clientName}, your loan of amount {$event->creditAmount} has been approved.";
        // Имитируем отправку email, выводя сообщение в лог
        $this->logger->info("Email sent to {$event->clientEmail}: {$message}");
    }
}
