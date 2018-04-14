<?php

namespace PHPGson;

use InvalidArgumentException;

class DataTransferObject
{
    private $fields = [];

    /**
     * @param String $name Method or property name
     * @param Object $value property value
     * @throws InvalidArgumentException
     */
    public function addField($name, $value = null)
    {
        if (empty($name))
            throw new InvalidArgumentException("Method or property name cannot be empty.");

        if (isset($this->fields[$name]))
            throw new InvalidArgumentException("Duplicated method or property for {$name}");

        $this->fields[$name] = $value;
    }
}