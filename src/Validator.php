<?php

namespace PoK\Validator;

abstract class Validator
{
    private $value;
    private $validValues;
    
    public function __construct($value)
    {
        $this->value = $value;
    }
    
    protected function getValue()
    {
        return $this->value;
    }
    
    public function setValidValues(array $values)
    {
        $this->validValues = $values;
        return $this;
    }
    
    protected function hasValidValues(): bool
    {
        return is_array($this->validValues) && !empty($this->validValues);
    }
    
    protected function getValidValues(): array
    {
        return $this->validValues;
    }
    
    abstract public function validate();
}
