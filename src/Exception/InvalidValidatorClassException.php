<?php

namespace PoK\Validator\Exception;

use PoK\Exception\HasDataInterface;
use PoK\Exception\ServerError\InternalServerErrorException;

class InvalidValidatorClassException extends InternalServerErrorException implements HasDataInterface
{
    private $got;

    public function __construct($got, \Throwable $previous = NULL)
    {
        parent::__construct('INVALID_VALIDATOR_CLASS', $previous);
        $this->got = is_object($got)
            ? get_class($got)
            : gettype($got);
    }

    public function getData()
    {
        return [
            'got' => $this->got
        ];
    }
}
