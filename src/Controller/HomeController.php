<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Messenger\Message\TracedMessage;

#[AsController]
#[Route(path:"/", methods:['GET'])]
class HomeController
{
    public function __construct(
        private MessageBusInterface $bus,
        private LoggerInterface $logger,
    ) {

    }

    public function __invoke(): Response
    {
        $this->logger->info('Dispatching message...');

        $this->bus->dispatch(new TracedMessage);

        $this->logger->info('Dispatched message...');

        return new Response();
    }
}