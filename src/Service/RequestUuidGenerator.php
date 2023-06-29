<?php

namespace App\Service;

use Symfony\Component\Uid\Uuid;

class RequestUuidGenerator implements RequestIdGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::v4()->toRfc4122(); // Or bin2hex(random_bytes(16)) or something else.
    }
}