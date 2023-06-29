<?php

namespace App\Service;

interface RequestIdGeneratorInterface
{
    public function generate(): string;
}