<?php

namespace App\Monolog;

use Symfony\Component\HttpFoundation\RequestStack;
use Monolog\Attribute\AsMonologProcessor;
use Monolog\LogRecord;

#[AsMonologProcessor]
class RequestIdProcessor implements \Monolog\Processor\ProcessorInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function __invoke(LogRecord $record) : LogRecord
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request && $request->headers->has('X-Request-ID')) {
            $record->extra['request_id'] = $request->headers->get('X-Request-ID');
        }

        return $record;
    }
}