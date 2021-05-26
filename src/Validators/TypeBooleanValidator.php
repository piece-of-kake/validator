<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeBoolean;

class TypeBooleanValidator extends Validator
{
    public function validate()
    {
        new TypeBoolean($this->getValue());
    }
}
