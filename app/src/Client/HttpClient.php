<?php

namespace App\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface as SymfonyHttpClientInterface;

class HttpClient implements HttpClientInterface
{

    public function __construct(
        private SymfonyHttpClientInterface $httpClient
    ) {}

    public function request(string $method, string $url): Response
    {
        $response = $this->httpClient->request($method, $url);
        return new Response(
            $response->getStatusCode(),
            $response->getContent(false)
        );
    }
}