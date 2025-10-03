<?php

namespace Kevinwbh\Chatrace\Exceptions;

class ValidationException extends ApiException
{
    protected array $errors = [];

    public function __construct(array $errors = [], ?array $responseData = null)
    {
        $this->errors = $errors;

        parent::__construct(
            "Error de validación en los parámetros enviados.",
            422,
            $responseData
        );
    }

    /**
     * Devuelve los errores de validación
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
