<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeCoordinates;

class CoordinatesValidator extends Validator
{
    public function validate()
    {
        new TypeCoordinates($this->getValue());
    }
}
