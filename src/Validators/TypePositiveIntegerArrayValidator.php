<?php

namespace PoK\Validator\Validators;

use PoK\ValueObject\Exception\InvalidPositiveIntegerArrayException;
use PoK\ValueObject\TypePositiveInteger;

class TypePositiveIntegerArrayValidator extends ArrayValidator
{
    public function validate()
    {
        parent::validate();
        try {
            foreach ($this->getValue() as $value) {
                new TypePositiveInteger($value);
            }
        } catch (\Exception $exception) {
            throw new InvalidPositiveIntegerArrayException();
        }
    }
}
