<?php

declare(strict_types=1);

namespace App\Controller;

use App\Messenger\Message\TracedMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route(path: "/", methods: ['GET'])]
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

        $this->bus->dispatch(new TracedMessage());

        $this->logger->info('Dispatched message...');

        return new JsonResponse([
            'message' => 'Dispatched',
        ]);
    }
}
