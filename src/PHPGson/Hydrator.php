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

/**
 * Class Hydrator
 * @package PHPGson
 */
class Hydrator
{
    private $properties;

    private $mode;

    /**
     * Hydrator constructor.
     * @param $jsonString
     * @param int $mode
     * @throws InvalidArgumentException
     */
    public function __construct($jsonString, $mode = Extractor::EXTRACTION_MODE_METHOD)
    {
        $this->properties = json_decode($jsonString);
        $this->mode = $mode;
        if (is_null($this->properties))
            throw new InvalidArgumentException('Invalid JSON string provided');
    }

    public function hydrate(&$object)
    {
        if (!is_object($object))
            throw new InvalidArgumentException('Output must be an object.');

        if ($this->mode == Extractor::EXTRACTION_MODE_METHOD)
            return $this->hydrateUsingMethods($object);

        return $this->hydrateUsingProperties($object);
    }

    /**
     * @param $object
     * @return bool
     */
    private function hydrateUsingMethods(&$object)
    {
    }

    /**
     * @param $object
     * @return bool
     */
    private function hydrateUsingProperties(&$object)
    {
    }

}