<?php

namespace App\Tests\Monolog;

use App\Messenger\Stamp\RequestIdStamp;
use App\Monolog\MessengerRequestIdProcessor;
use DateTimeImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;

class MessengerRequestIdProcessorTest extends TestCase
{
    public function testProcessRecord()
    {
        $requestId = 'test-id';
        $processor = new MessengerRequestIdProcessor();

        $processor->setStamp(new RequestIdStamp($requestId));

        $record = $processor(new LogRecord(
            new DateTimeImmutable(),
            'random-channel',
            Level::Info,
            'a message'
        ));

        $this->assertEquals($requestId, $record['extra']['request_id']);
    }
}
