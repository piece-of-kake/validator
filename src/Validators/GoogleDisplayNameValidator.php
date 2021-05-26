<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeGoogleDisplayName;

class GoogleDisplayNameValidator extends Validator
{
    public function validate()
    {
        new TypeGoogleDisplayName($this->getValue());
    }
}
