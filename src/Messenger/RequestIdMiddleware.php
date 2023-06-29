<?php

namespace App\Messenger;

use App\Monolog\MessengerRequestIdProcessor;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestIdMiddleware implements MiddlewareInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private MessengerRequestIdProcessor $messengerRequestIdProcessor
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        // If message is dispatched by a consumer, reuse the stamp
        if ($stamp = $envelope->last(RequestIdStamp::class)) {
            $this->messengerRequestIdProcessor->setEnvelope($envelope);
            return $stack->next()->handle($envelope, $stack);
        }

        $request = $this->requestStack->getCurrentRequest();
        if ($request && $request->headers->has('X-Request-ID')) {
            $envelope = $envelope->with(new RequestIdStamp($request->headers->get('X-Request-ID')));
        }

        return $stack->next()->handle($envelope, $stack);
    }
}