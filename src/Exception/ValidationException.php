<?php

namespace PoK\Validator\Exception;

use PoK\Exception\ClientError\BadRequestException;
use PoK\Exception\HasDataInterface;
use PoK\ValueObject\Collection;

class ValidationException extends BadRequestException implements HasDataInterface
{
    /**
     * @var Collection
     */
    private $errors;

    public function __construct(Collection $validationErrors, \Throwable $previous = NULL)
    {
        parent::__construct('VALIDATION_EXCEPTION', $previous);
        $this->errors = $validationErrors;
    }

    public function getData()
    {
        return $this->errors->toArray();
    }
}
