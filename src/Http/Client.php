<?php

namespace Kevinwbh\Chatrace\Http;

use GuzzleHttp\Client as Guzzle;
use Kevinwbh\Chatrace\Exceptions\ApiException;
use Kevinwbh\Chatrace\Exceptions\AuthenticationException;
use Kevinwbh\Chatrace\Exceptions\ValidationException;

class Client
{
    private Guzzle $http;

    public function __construct(string $apiKey)
    {
        $this->http = new Guzzle([
            'base_uri' => 'https://api.chatrace.com/',
            'headers'  => [
                'X-ACCESS-TOKEN' => $apiKey,
                'Accept'        => 'application/json',
            ],
        ]);
    }

    public function get(string $uri, array $params = [])
    {
        return $this->request('GET', $uri, ['query' => $params]);
    }

    public function post(string $uri, array $data = [])
    {
        return $this->request('POST', $uri, ['json' => $data]);
    }

    private function request(string $method, string $uri, array $options = [])
    {
        $response = $this->http->request($method, $uri, $options);

        $status = $response->getStatusCode();
        $decoded = json_decode((string) $response->getBody(), true);

        if ($status === 401) {
            throw new AuthenticationException($decoded);
        }

        if ($status === 422) {
            throw new ValidationException($decoded['errors'] ?? [], $decoded);
        }

        if ($status >= 400) {
            throw new ApiException($decoded['message'] ?? 'Error desconocido', $status, $decoded);
        }

        return new Response($response);
    }
}
