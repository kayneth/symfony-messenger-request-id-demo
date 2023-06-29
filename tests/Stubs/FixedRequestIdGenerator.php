<?php

namespace App\Tests\Stubs;

use App\Service\RequestIdGeneratorInterface;

class FixedRequestIdGenerator implements RequestIdGeneratorInterface
{
    public function __construct(private string $requestId) 
    {}

    public function generate(): string
    {
        return $this->requestId;
    }
}