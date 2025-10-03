<?php

namespace Kevinwbh\Chatrace\Exceptions;

class AuthenticationException extends ApiException
{
    public function __construct(?array $responseData = null)
    {
        parent::__construct(
            "Error de autenticación: API key inválida o expirada.",
            401,
            $responseData
        );
    }
}
