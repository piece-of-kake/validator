<?php

namespace PoK\Validator\Exception;

use PoK\Exception\ServerError\InternalServerErrorException;

class InvalidPositiveIntegerArrayException extends InternalServerErrorException
{
    public function __construct(\Throwable $previous = NULL) {
        parent::__construct('INVALID_POSITIVE_INTEGER_ARRAY_VALUE', $previous);
    }
}
