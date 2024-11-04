<?php

declare(strict_types=1);

namespace App\Util\Messenger;

use App\Util\Domain\EventDispatcher\EventDispatcher;

final class MessageHandler
{
    public function __construct(
        private EventDispatcher $dispatcher
    ) {
    }

    public function __invoke(Message $message): void
    {
        $this->dispatcher->dispatch([$message->getEvent()]);
    }
}
