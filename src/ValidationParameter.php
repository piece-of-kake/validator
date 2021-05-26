<?php

namespace PoK\Validator;

class ValidationParameter
{

    private $name;
    private $required = false;
    private $default;
    private $hasDefault = false;
    private $validatorClass;
    private $dependencies = [];
    private $castClass;
    private $makeClass;
    private $validValues;

    public function name(string $name): ValidationParameter
    {
        $this->name = $name;
        return $this;
    }

    public function required(): ValidationParameter
    {
        $this->required = true;
        return $this;
    }

    public function default($defaultValue): ValidationParameter
    {
        $this->default = $defaultValue;
        $this->hasDefault = true;
        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function hasDefault(): bool
    {
        return $this->hasDefault;
    }

    public function validator(string $validatorClass): ValidationParameter
    {
        $this->validatorClass = $validatorClass;
        return $this;
    }

    public function depends(callable $dependencySetup): ValidationParameter
    {
        $dependency = new ValidationDependency();
        $this->dependencies[] = $dependency;
        $dependencySetup($dependency);
        return $this;
    }

    public function hasDependencies(): bool
    {
        return !empty($this->dependencies);
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function validValues(...$validValues): ValidationParameter
    {
        $this->validValues = $validValues;
        return $this;
    }

    public function castTo(string $castClass): ValidationParameter
    {
        $this->castClass = $castClass;
        return $this;
    }

    public function make(string $reconstituteClass): ValidationParameter
    {
        $this->makeClass = $reconstituteClass;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getValidatorClass(): string
    {
        return $this->validatorClass;
    }

    public function hasCastClass(): bool
    {
        return (bool) $this->castClass;
    }

    public function getCastClass(): string
    {
        return $this->castClass;
    }

    public function hasMakeClass(): bool
    {
        return (bool) $this->makeClass;
    }

    public function getMakeClass(): string
    {
        return $this->makeClass;
    }

    public function hasValidValues(): bool
    {
        return is_array($this->validValues) && !empty($this->validValues);
    }

    public function getValidValues(): array
    {
        return $this->validValues;
    }

}
