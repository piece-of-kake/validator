<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\Exception\ValueOutOfBoundsException;
use PoK\ValueObject\TypePositiveInteger;

class TypePositiveIntegerValidator extends Validator
{
    public function validate()
    {
        if ($this->hasValidValues())
            if (!in_array($this->getValue(), $this->getValidValues())) throw new ValueOutOfBoundsException();
        new TypePositiveInteger($this->getValue());
    }
}
