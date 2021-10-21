<?php

namespace PoK\Validator\Exception;

use PoK\Exception\ClientError\BadRequestException;

class ValueOutOfBoundsException extends BadRequestException
{
    public function __construct(\Throwable $previous = NULL)
    {
        parent::__construct('VALUE_OUT_OF_BOUNDS', $previous);
    }
}
