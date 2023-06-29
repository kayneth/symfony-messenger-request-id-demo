<?php

namespace App\Middleware;

use App\Service\RequestIdGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RequestIdMiddleware implements EventSubscriberInterface
{
    public function __construct(
        private RequestIdGeneratorInterface $requestIdGenerator
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 15],
            KernelEvents::RESPONSE => ['onKernelResponse', -15],
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->headers->has('X-Request-ID')) {
            $request->headers->set('X-Request-ID', $this->requestIdGenerator->generate());
        }
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();
        if (!$response->headers->has('X-Request-ID') && $request->headers->has('X-Request-ID')) {
            $response->headers->set('X-Request-ID', $request->headers->get('X-Request-ID'));
        }
    }
}