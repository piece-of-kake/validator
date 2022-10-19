<?php

namespace PoK\Validator\Exception;

use PoK\Exception\ServerError\InternalServerErrorException;

class InvalidNonEmptyStringArrayException extends InternalServerErrorException
{
    public function __construct(\Throwable $previous = NULL) {
        parent::__construct('INVALID_NON_EMPTY_STRING_ARRAY_VALUE', $previous);
    }
}
