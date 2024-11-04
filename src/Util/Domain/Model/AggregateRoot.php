<?php

declare(strict_types=1);

namespace App\Util\Domain\Model;

abstract class AggregateRoot
{
    private array $events = [];

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    protected function recordEvent(Event $event): void
    {
        array_push($this->events, $event);
    }
}
