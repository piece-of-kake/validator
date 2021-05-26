<?php

namespace PoK\Validator;

class ValidationDependency
{

    /**
     * @var string
     */
    private $must;

    /**
     * @var string
     */
    private $mustNot;

    /**
     * @var string
     */
    private $orRequire;

    /**
     * @var string
     */
    private $requireIfEqualValue;

    /**
     * @var mixed
     */
    private $requireIfEqualField;

    /**
     * @var string
     */
    private $different;

    /**
     * Specified field name must coexist in request data
     * ##HAS field -> dependency -> MUST have field
     *
     * @param string $fieldName
     * @return \PoK\Validator\ValidationDependency
     */
    public function must(string $fieldName): ValidationDependency
    {
        $this->must = $fieldName;
        return $this;
    }

    /**
     * @param string $fieldName
     * @param $value
     * @return $this
     */
    public function requireIfEqual(string $fieldName, $value): ValidationDependency
    {
        $this->requireIfEqualField = $fieldName;
        $this->requireIfEqualValue = $value;
        return $this;
    }

    /**
     * Specified field name must not appear in request
     * ##HAS field -> dependency -> MUST NOT have field
     *
     * @param string $fieldName
     * @return \PoK\Validator\ValidationDependency
     */
    public function mustNot(string $fieldName): ValidationDependency
    {
        $this->mustNot = $fieldName;
        return $this;
    }

    /**
     * If the field name is missing from the request then the specified one must be defined
     * ## DOESN'T HAVE field -> dependency -> MUST have field
     *
     * @param string $fieldName
     * @return \PoK\Validator\ValidationDependency
     */
    public function orRequire(string $fieldName): ValidationDependency
    {
        $this->orRequire = $fieldName;
        return $this;
    }

    /**
     * Value of the field must be different than the value of the specified field
     * ##HAS field -> dependency -> MUST be different value
     *
     * @param string $fieldName
     * @return \PoK\Validator\ValidationDependency
     */
    public function different(string $fieldName): ValidationDependency
    {
        $this->different = $fieldName;
        return $this;
    }

    public function hasMust(): bool
    {
        return is_string($this->must);
    }

    public function getMust(): string
    {
        return $this->must;
    }

    public function hasMustNot(): bool
    {
        return is_string($this->mustNot);
    }

    public function getMustNot(): string
    {
        return $this->mustNot;
    }

    public function hasOrRequire(): bool
    {
        return is_string($this->orRequire);
    }

    public function getOrRequire(): string
    {
        return $this->orRequire;
    }

    public function hasRequireIfEqual(): bool
    {
        return is_string($this->requireIfEqualField);
    }

    /**
     * @return string
     */
    public function getRequireIfEqualValue(): string
    {
        return $this->requireIfEqualValue;
    }

    /**
     * @return mixed
     */
    public function getRequireIfEqualField()
    {
        return $this->requireIfEqualField;
    }

    public function hasDifferent(): bool
    {
        return is_string($this->different);
    }

    /**
     * @return string
     */
    public function getDifferent(): string
    {
        return $this->different;
    }
}
