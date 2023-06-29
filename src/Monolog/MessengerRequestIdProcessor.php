<?php

namespace App\Monolog;

use App\Messenger\RequestIdStamp;
use Symfony\Component\Messenger\Envelope;
use Monolog\Attribute\AsMonologProcessor;
use Monolog\LogRecord;

#[AsMonologProcessor]
class MessengerRequestIdProcessor
{
    private ?string $requestId = null;

    public function setEnvelope(Envelope $envelope): void
    {
        /** @var RequestIdStamp|null $stamp */
        $stamp = $envelope->last(RequestIdStamp::class);
        if ($stamp !== null) {
            $this->requestId = $stamp->getRequestId();
        }
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        if ($this->requestId !== null) {
            $record->extra['request_id'] = $this->requestId;
        }

        return $record;
    }
}