<?php

declare(strict_types=1);

namespace App\Util\Domain\EventDispatcher;

interface EventDispatcher
{
    public function dispatch(array $events): void;

    public function addEventListener(string $eventName, callable $listener): void;
}
