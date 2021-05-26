<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeUUID4;

class UUID4Validator extends Validator
{
    public function validate()
    {
        new TypeUUID4($this->getValue());
    }
}
