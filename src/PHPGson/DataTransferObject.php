<?php

/**
 * PHPGson Library
 * Simple entity mapper for PHP applications
 * with minimum requirements and dependencies
 *
 * @author Rafal Martinez-Marjanski
 * @package PHPGson
 * @license MIT
 */

namespace PHPGson;

use InvalidArgumentException;

class DataTransferObject
{
    private $fields = [];

    private $mode;

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

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->fields;
    }

    /**
     * @param string $name property/method name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->fields[$name]))
            return $this->fields[$name];

        throw new InvalidArgumentException("Field {$name} does not exist.");
    }

    /**
     * @param string $name property/method name
     * @return mixed
     */
    public function get($name)
    {
        if (isset($this->fields[$name]))
            return $this->fields[$name];

        throw new InvalidArgumentException("Field {$name} does not exist.");
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }


}