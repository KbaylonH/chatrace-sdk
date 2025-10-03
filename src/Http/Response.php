<?php

namespace Kevinwbh\Chatrace\Http;

use Psr\Http\Message\ResponseInterface;
use Kevinwbh\Chatrace\Exceptions\ApiException;

class Response
{
    protected ResponseInterface $response;
    protected ?array $decodedBody = null;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Código HTTP (200, 201, 400, etc.)
     */
    public function status(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * Devuelve el body como string crudo
     */
    public function body(): string
    {
        return (string) $this->response->getBody();
    }

    /**
     * Devuelve el body parseado a array (JSON)
     */
    public function json(): array
    {
        if ($this->decodedBody === null) {
            $decoded = json_decode($this->body(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiException(
                    "Error al decodificar JSON: " . json_last_error_msg(),
                    $this->status()
                );
            }

            $this->decodedBody = $decoded;
        }

        return $this->decodedBody;
    }

    /**
     * Atajo para acceder a una clave del JSON
     */
    public function get(string $key, $default = null)
    {
        $json = $this->json();
        return $json[$key] ?? $default;
    }

    /**
     * Devuelve headers completos o un header específico
     */
    public function header(string $name = null)
    {
        if ($name === null) {
            return $this->response->getHeaders();
        }

        return $this->response->getHeaderLine($name);
    }

    /**
     * Indica si la respuesta fue exitosa (2xx)
     */
    public function successful(): bool
    {
        return $this->status() >= 200 && $this->status() < 300;
    }
}
