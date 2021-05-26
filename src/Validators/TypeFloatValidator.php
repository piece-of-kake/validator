<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeFloat;

class TypeFloatValidator extends Validator
{
    public function validate()
    {
        new TypeFloat($this->getValue());
    }
}
