<?php

declare(strict_types=1);

namespace App\Messenger\Handler;

use App\Messenger\Message\AsyncDispatchedMessage;
use App\Messenger\Message\TracedMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class TracedMessageHandler
{
    public function __construct(
        private MessageBusInterface $bus,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(TracedMessage $message): void
    {
        $this->logger->warning('Handling TracedMessage...');

        $this->bus->dispatch(new AsyncDispatchedMessage());
    }
}
