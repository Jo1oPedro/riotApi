<?php

namespace App\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface as SymfonyHttpClientInterface;

class HttpClient implements HttpClientInterface
{

    public function __construct(
        private SymfonyHttpClientInterface $httpClient
    ) {}

    public function request(string $method, string $url): array
    {
        return $this->httpClient->request($method, $url);
    }
}