<?php

namespace PoK\Validator;

use PoK\Validator\Exception\ValueOutOfBoundsException;
use PoK\Validator\Request\ParameterManipulationInterface;
use PoK\ValueObject\Collection;
use PoK\Validator\Exception\ValidationException;
use PoK\Validator\Exception\InvalidValidatorClassException;

class ValidationManager
{
    private $parameters;

    // Missing required fields
    private $missing = [];
    // Invalid fields
    private $invalid = [];
    private $outOfBounds = []; // When valid values are set for a specific parameter
    // Broken dependencies
    private $must = [];
    private $mustNot = [];
    private $orRequires = [];
    private $requireIfEqual = [];
    private $different = [];

    public function __construct()
    {
        $this->parameters = new Collection([]);
    }

    /**
     * @param callable $validationSetup
     * @return ValidationManager
     */
    public function parameter(callable $validationSetup): ValidationManager
    {
        $parameter = new ValidationParameter();
        $validationSetup($parameter);
        $this->parameters[$parameter->getName()] = $parameter;
        return $this;
    }

    public function validate(ParameterManipulationInterface $request): ValidationManager
    {
        $this
            ->setDefaults($request)
            ->sanitize($request)
            ->setMissing($request)
            ->validateParameters($request)
            ->setDependencies($request);

        $errors = new Collection([]);
        if (!empty($this->missing)) $errors['missing'] = $this->missing;
        if (!empty($this->invalid)) $errors['invalid'] = $this->invalid;
        if (!empty($this->must)) $errors['must'] = $this->must;
        if (!empty($this->mustNot)) $errors['must_not'] = $this->mustNot;
        if (!empty($this->orRequires)) $errors['or_requires'] = $this->orRequires;
        if (!empty($this->requireIfEqual)) $errors['require_if_equal'] = $this->requireIfEqual;
        if (!empty($this->different)) $errors['different'] = $this->different;
        if (!empty($this->outOfBounds)) $errors['out_of_bounds'] = $this->outOfBounds;

        if (!$errors->isEmpty())
            throw new ValidationException($errors);

        $this
            ->castValues($request)
            ->castCollectionValues($request)
            ->makeValues($request);

        return $this;
    }

    private function setDefaults(ParameterManipulationInterface $request): ValidationManager
    {
        $this->missing = [];
        foreach ($this->parameters as $key => $parameter) {
            /** @var ValidationParameter $parameter */
            if ($parameter->hasDefault() && !$request->hasParameter($key))
                $request->setParameter($parameter->getName(), $parameter->getDefault());
        }
        return $this;
    }

    private function sanitize(ParameterManipulationInterface $request): ValidationManager
    {
        foreach ($this->parameters as $key => $parameter) {
            /** @var ValidationParameter $parameter */
            if ($parameter->hasSanitizers()) {
                $value = $request->getParameter($key);
                foreach ($parameter->getSanitizers() as $sanitizer) {
                    $value = $sanitizer->sanitize($value);
                }
                $request->setParameter($key, $value);
            }
        }
        return $this;
    }

    private function setMissing(ParameterManipulationInterface $request)
    {
        $this->missing = [];
        foreach ($this->parameters as $key => $parameter) {
            if ($parameter->isRequired() && !$request->hasParameter($key))
                $this->missing[] = $key;
        }
        return $this;
    }

    private function setDependencies(ParameterManipulationInterface $request)
    {
        $this->must = [];
        $this->mustNot = [];
        $this->orRequires = [];
        $this->requireIfEqual = [];
        $this->different = [];

        foreach ($this->parameters as $key => $parameter) {
            if ($parameter->hasDependencies()) {
                $dependencies = $parameter->getDependencies();
                foreach ($dependencies as $dependency) {
                    /**
                     * @var ValidationDependency $dependency
                     */
                    switch (true) {
                        case $dependency->hasMust():
                            $dependencyName = $dependency->getMust();
                            if ($request->hasParameter($key) && !$request->hasParameter($dependencyName))
                                $this->must[$key] = $dependencyName;
                            break;
                        case $dependency->hasMustNot():
                            $dependencyName = $dependency->getMustNot();
                            if ($request->hasParameter($key) && $request->hasParameter($dependencyName))
                                $this->mustNot[$key] = $dependencyName;
                            break;
                        case $dependency->hasOrRequire():
                            $dependencyName = $dependency->getOrRequire();
                            if (
                                !$request->hasParameter($key) &&
                                !$request->hasParameter($dependencyName) &&
                                (
                                    !isset($this->orRequires[$dependencyName]) ||
                                    $this->orRequires[$dependencyName] !== $key
                                )
                            ) {
                                $this->orRequires[$key] = $dependencyName;
                            }
                            break;
                        case $dependency->hasRequireIfEqual():
                            $dependencyName = $dependency->getRequireIfEqualField();
                            $expectedValue = $dependency->getRequireIfEqualValue();
                            if (
                                $request->hasParameter($dependencyName) &&
                                $request->getParameter($dependencyName) == $expectedValue && // loose comparison here cause values aren't cast yet
                                !$request->hasParameter($key)
                            ) {
                                $this->requireIfEqual[$key] = $dependencyName;
                            }
                            break;
                        case $dependency->hasDifferent():
                            $dependencyName = $dependency->getDifferent();
                            if (
                                $request->hasParameter($key) &&
                                $request->hasParameter($dependencyName) &&
                                $request->getParameter($key) == $request->getParameter($dependencyName)
                            )
                                $this->different[$key] = $dependencyName;
                            break;
                    }
                }
            }
        }

        return $this;
    }

    private function validateParameters(ParameterManipulationInterface $request)
    {
        $this->invalid = [];
        foreach ($this->parameters as $key => $parameter) {
            if ($request->hasParameter($key)) {
                $validatorClass = $parameter->getValidatorClass();
                $validator = new $validatorClass($request->getParameter($key));
                if (!($validator) instanceof Validator) throw new InvalidValidatorClassException($validator);
                try {
                    if ($parameter->hasValidValues()) $validator->setValidValues($parameter->getValidValues());
                    $validator->validate();
                } catch (ValueOutOfBoundsException $exception) {
                    $this->outOfBounds[$key] = $exception->getMessage();
                } catch (\Throwable $exception) {
                    $this->invalid[$key] = $exception->getMessage();
                }
            }
        }
        return $this;
    }

    private function castValues(ParameterManipulationInterface $request)
    {
        foreach ($this->parameters as $key => $parameter) {
            if ($parameter->hasCastClass() && $request->hasParameter($key)) {
                $castClass = $parameter->getCastClass();
                $request->setParameter($key, new $castClass($request->getParameter($key)));
            }
        }
        return $this;
    }

    private function castCollectionValues(ParameterManipulationInterface $request)
    {
        foreach ($this->parameters as $key => $parameter) {
            if ($parameter->hasCastCollectionClass() && $request->hasParameter($key) && is_array($request->getParameter($key))) {
                $castClass = $parameter->getCastCollectionClass();
                $collection = new Collection([]);
                foreach ($request->getParameter($key) as $value) {
                    $collection[] = new $castClass($value);
                }
                $request->setParameter($key, $collection);
            }
        }
        return $this;
    }

    private function makeValues($request)
    {
        foreach ($this->parameters as $key => $parameter) {
            if ($parameter->hasMakeClass() && $request->hasParameter($key)) {
                $makeClass = $parameter->getMakeClass();
                $request->setParameter($key, (new $makeClass())->make(
                    is_array($request->getParameter($key))
                        ? new Collection($request->getParameter($key))
                        : $request->getParameter($key)
                ));
            }
        }
        return $this;
    }
}
