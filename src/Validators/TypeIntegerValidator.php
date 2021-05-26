<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeInteger;

class TypeIntegerValidator extends Validator
{
    public function validate()
    {
        new TypeInteger($this->getValue());
    }
}
