<?php

namespace App\Tests\Middleware;

use App\Middleware\RequestIdMiddleware;
use App\Service\RequestUuidGenerator;
use App\Tests\Stubs\FixedRequestIdGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Response;

class RequestIdMiddlewareTest extends TestCase
{
    public function testOnKernelRequest()
    {
        $requestId = 'test-id';

        $middleware = new RequestIdMiddleware(new FixedRequestIdGenerator($requestId));

        $request = new Request();
        $event = new RequestEvent(
            $this->createMock(HttpKernelInterface::class), 
            $request, 
            HttpKernelInterface::MAIN_REQUEST
        );

        $middleware->onKernelRequest($event);

        $this->assertEquals($requestId, $request->headers->get('X-Request-ID'));
    }

    public function testOnKernelResponse()
    {
        $requestId = 'test-id';

        $middleware = new RequestIdMiddleware(new RequestUuidGenerator);

        $request = new Request();
        $request->headers->set('X-Request-ID', $requestId);
        $response = new Response();

        $event = new ResponseEvent(
            $this->createMock(HttpKernelInterface::class), 
            $request, 
            HttpKernelInterface::MAIN_REQUEST, 
            $response
        );

        $middleware->onKernelResponse($event);

        $this->assertEquals($requestId, $response->headers->get('X-Request-ID'));
    }
}
