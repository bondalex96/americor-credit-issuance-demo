<?php

declare(strict_types=1);

namespace CreditProcessing\Infrastructure\EventListener;

use App\CreditProcessing\Domain\Credit\CreditIssued;
use Psr\Log\LoggerInterface;

final class SmsNotificationListener
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    public function onCreditIssued(CreditIssued $event): void
    {
        // Имитируем отправку sms, выводя сообщение в лог
        $message = "Dear {$event->clientName}, your loan of amount {$event->creditAmount} has been approved.";
        $this->logger->info("SMS sent to {$event->clientPhone}: {$message}");
    }
}
