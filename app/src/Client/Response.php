<?php

namespace App\Client;

class Response
{
    public function __construct(
        private string $statusCode,
        private string $content
    ) {}

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function getContent($jsonDecode = true): \stdClass|string|array
    {
        return ($jsonDecode) ? json_decode($this->content) : $this->content;
    }
}