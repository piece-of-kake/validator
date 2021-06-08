<?php

namespace PoK\Validator\Sanitizers;

interface CanSanitize
{
    /**
     * Returns a sanitized value
     *
     * @param mixed $value
     * @return mixed
     */
    public function sanitize($value);
}