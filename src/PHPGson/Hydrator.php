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

/**
 * Class Hydrator
 * @package PHPGson
 */
class Hydrator
{
    private $properties;


    public function __construct(array $properties)
    {
    }

    public function hydrate($object)
    {
        foreach ($this->properties as $property) {

        }
    }
}