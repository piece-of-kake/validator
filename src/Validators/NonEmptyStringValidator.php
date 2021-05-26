<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeString;
use PoK\ValueObject\Exception\EmptyStringException;

class NonEmptyStringValidator extends Validator
{
    public function validate()
    {
        new TypeString($this->getValue());
        if ((string) $this->getValue() === '') throw new EmptyStringException();
    }
}
