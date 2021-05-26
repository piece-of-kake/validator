<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeIP;

class IPValidator extends Validator
{
    public function validate()
    {
        new TypeIP($this->getValue());
    }
}
