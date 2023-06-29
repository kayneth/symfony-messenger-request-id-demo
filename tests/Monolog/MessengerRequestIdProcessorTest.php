<?php

namespace App\Tests\Monolog;

use App\Messenger\RequestIdStamp;
use App\Monolog\MessengerRequestIdProcessor;
use DateTimeImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;

class MessengerRequestIdProcessorTest extends TestCase
{
    public function testProcessRecord()
    {
        $requestId = 'test-id';
        $processor = new MessengerRequestIdProcessor();

        $envelope = (new Envelope(new \stdClass()))->with(new RequestIdStamp($requestId));
        $processor->setEnvelope($envelope);

        $record = $processor(new LogRecord(
            new DateTimeImmutable(),
            'random-channel',
            Level::Info,
            'a message'
        ));

        $this->assertEquals($requestId, $record['extra']['request_id']);
    }
}