<?php

declare(strict_types=1);

namespace App\Messenger\Handler;

use Psr\Log\LoggerInterface;
use App\Messenger\Message\TracedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TracedMessageHandler
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(TracedMessage $message)
    {
        $this->logger->info('Handling message...');
    }
}