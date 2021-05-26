<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypePositiveInteger;

class TypePositiveIntegerValidator extends Validator
{
    public function validate()
    {
        new TypePositiveInteger($this->getValue());
    }
}
