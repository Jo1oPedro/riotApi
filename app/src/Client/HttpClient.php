<?php

namespace App\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface as SymfonyHttpClientInterface;

class HttpClient implements HttpClientInterface
{

    public function __construct(
        private SymfonyHttpClientInterface $httpClient
    ) {}

    public function request(string $method, string $url, bool $toArray = true): string|array
    {
        $response = $this->httpClient->request($method, $url);
        return ($toArray) ? $response->toArray() : $response->getContent();
    }
}