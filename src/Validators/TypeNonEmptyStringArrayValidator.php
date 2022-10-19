<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Exception\InvalidNonEmptyStringArrayException;
use PoK\Validator\Exception\ValueOutOfBoundsException;
use PoK\ValueObject\Exception\EmptyStringException;
use PoK\ValueObject\TypeString;

class TypeNonEmptyStringArrayValidator extends ArrayValidator
{
    public function validate()
    {
        parent::validate();
        try {
            foreach ($this->getValue() as $value) {
                if ($this->hasValidValues())
                    if (!in_array($value, $this->getValidValues())) throw new ValueOutOfBoundsException();

                new TypeString($value);
                if ((string) $value === '') throw new EmptyStringException();
            }
        } catch (ValueOutOfBoundsException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            throw new InvalidNonEmptyStringArrayException();
        }
    }
}
