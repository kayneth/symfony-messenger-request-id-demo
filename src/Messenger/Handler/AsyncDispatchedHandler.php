<?php

declare(strict_types=1);

namespace App\Messenger\Handler;

use App\Messenger\Message\AsyncDispatchedMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AsyncDispatchedHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(AsyncDispatchedMessage $message): void
    {
        $this->logger->warning('Handling AsyncDispatchedMessage...');
    }
}
