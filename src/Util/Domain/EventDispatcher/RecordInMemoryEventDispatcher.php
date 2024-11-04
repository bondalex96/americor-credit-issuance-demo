<?php

declare(strict_types=1);

namespace App\Util\Domain\EventDispatcher;

final class RecordInMemoryEventDispatcher implements EventDispatcher
{
    private array $triggeredEvents = [];

    public function dispatch(array $events): void
    {
        $this->triggeredEvents = array_merge($this->triggeredEvents, $events);
    }

    public function addEventListener(string $eventName, callable $listener): void
    {
    }

    public function getTriggeredEvents(): array
    {
        return $this->triggeredEvents;
    }
}
