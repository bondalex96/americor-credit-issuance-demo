<?php

declare(strict_types=1);

namespace App\Util\Domain\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcher;

final class SymfonyEventDispatcherAdapter implements EventDispatcher
{
    public function __construct(private readonly SymfonyEventDispatcher $eventDispatcher)
    {
    }

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatchEvent($event);
        }
    }

    public function addEventListener(string $eventName, callable $listener): void
    {
        $this->eventDispatcher->addListener($eventName, $listener);
    }

    public function getListeners(string $eventName): array
    {
        return $this->eventDispatcher->getListeners($eventName);
    }

    private function dispatchEvent(object $event): void
    {
        $eventName = $this->extractEventName($event);

        $listeners = $this
            ->eventDispatcher
            ->getListeners($eventName);

        foreach ($listeners as $listener) {
            \call_user_func($listener, $event);
        }
    }

    private function extractEventName(object $event): string
    {
        return get_class($event);
    }
}
