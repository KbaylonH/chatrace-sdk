<?php

namespace Kevinwbh\Chatrace\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected ?array $responseData = null;
    protected int $statusCode;

    public function __construct(string $message, int $statusCode = 0, ?array $responseData = null)
    {
        parent::__construct($message, $statusCode);
        $this->statusCode   = $statusCode;
        $this->responseData = $responseData;
    }

    /**
     * Devuelve el código HTTP de la respuesta
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Devuelve el cuerpo de la respuesta decodificado si lo hay
     */
    public function getResponseData(): ?array
    {
        return $this->responseData;
    }
}
