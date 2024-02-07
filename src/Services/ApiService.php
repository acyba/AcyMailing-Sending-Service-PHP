<?php

namespace AcyMailer\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiService
{
    private string $apiKey;

    private Client $client;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->createClient();
    }

    private function createClient(): void
    {
        $this->client = new Client([
            'base_uri' => 'https://api.acymailer.com',
        ]);
    }

    private function getHeaders($method): array
    {
        return [
            'API-KEY' => $this->apiKey,
            'Content-Type' => $method === 'PATCH' ? 'application/merge-patch+json' : 'application/json',
            'Version' => 'external',
        ];
    }

    /**
     * @throws Exception
     */
    public function request(string $uri, array $options = []): array
    {
        $method = $options['method'] ?? 'GET';

        $url = 'https://api.acymailer.com'.$uri;

        $requestOptions = [];

        if (isset($options['headers'])) {
            $requestOptions['headers'] = array_merge($this->getHeaders($method), $options['headers']);
        } else {
            $requestOptions['headers'] = $this->getHeaders($method);
        }

        if (isset($options['body'])) {
            $requestOptions['json'] = $options['body'];
        }

        try {
            $response = $this->client->request($method, $url, $requestOptions);
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage());
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
