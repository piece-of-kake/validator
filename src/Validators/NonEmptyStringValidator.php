<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Exception\ValueOutOfBoundsException;
use PoK\Validator\Validator;
use PoK\ValueObject\TypeString;
use PoK\ValueObject\Exception\EmptyStringException;

class NonEmptyStringValidator extends Validator
{
    public function validate()
    {
        if ($this->hasValidValues())
            if (!in_array($this->getValue(), $this->getValidValues())) throw new ValueOutOfBoundsException();

        new TypeString($this->getValue());
        if ((string) $this->getValue() === '') throw new EmptyStringException();
    }
}
