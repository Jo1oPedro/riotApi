<?php

namespace App\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface as SymfonyHttpClientInterface;

interface HttpClientInterface
{
    public function __construct(SymfonyHttpClientInterface $httpClient);
    public function request(string $method, string $url, bool $toArray = true): string|array;
}