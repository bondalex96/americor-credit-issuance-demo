<?php

declare(strict_types=1);

namespace App\Util\Domain\EventDispatcher;

use App\Util\Messenger\Message;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventDispatcher implements EventDispatcher
{
    public function __construct(
        private MessageBusInterface $bus
    ) {
    }

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->bus->dispatch(new Message($event));
        }
    }

    public function addEventListener(string $eventName, callable $listener): void
    {
        return;
    }
}
