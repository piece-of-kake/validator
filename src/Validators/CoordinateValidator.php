<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeCoordinate;

class CoordinateValidator extends Validator
{
    public function validate()
    {
        new TypeCoordinate($this->getValue());
    }
}
