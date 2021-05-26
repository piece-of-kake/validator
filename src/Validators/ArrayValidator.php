<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\Exception\NotAnArrayException;

class ArrayValidator extends Validator
{
    public function validate()
    {
        if(!is_array($this->getValue()))
            throw new NotAnArrayException();
    }
}
