<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Exception\ValueOutOfBoundsException;
use PoK\ValueObject\Exception\InvalidPositiveIntegerArrayException;
use PoK\ValueObject\TypePositiveInteger;

class TypePositiveIntegerArrayValidator extends ArrayValidator
{
    public function validate()
    {
        parent::validate();
        try {
            foreach ($this->getValue() as $value) {
                if ($this->hasValidValues())
                    if (!in_array($value, $this->getValidValues())) throw new ValueOutOfBoundsException();
                new TypePositiveInteger($value);
            }
        } catch (ValueOutOfBoundsException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            throw new InvalidPositiveIntegerArrayException();
        }
    }
}
