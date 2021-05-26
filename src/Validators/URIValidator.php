<?php

namespace PoK\Validator\Validators;

use PoK\Validator\Validator;
use PoK\ValueObject\TypeURI;
use PoK\ValueObject\Exception\InvalidURLException;

class URIValidator extends Validator
{
    public function validate()
    {
        TypeURI::makeFromString($this->getValue());
        if ((string) $this->getValue() === '') throw new InvalidURLException();
    }
}
