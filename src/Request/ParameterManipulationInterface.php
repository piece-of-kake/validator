<?php

namespace PoK\Validator\Request;

interface ParameterManipulationInterface
{
    /**
     * Will be used to cast input parameters to value objects.
     *
     * @param $name
     * @param $value
     * @return ParameterManipulationInterface
     */
    public function setParameter($name, $value);

    /**
     * Retrieves a value of a specified request parameter, or null if it is not set.
     *
     * @param $name
     * @return mixed|null
     */
    public function getParameter($name);

    /**
     * Checks if a specified parameter exists in the request.
     * Even if the parameter was set to null, NULL is a value..
     *
     * @param $name
     * @return bool
     */
    public function hasParameter($name): bool;
}