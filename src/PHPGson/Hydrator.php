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
    private function __construct() {}

    /**
     * @param $object
     * @param $jsonString
     * @param int $mode
     * @return bool
     */
    public static function hydrate(&$object, $jsonString, $mode = Extractor::EXTRACTION_MODE_METHOD)
    {
        if (is_null(json_decode($jsonString)))
            throw new InvalidArgumentException('Invalid JSON string provided');

        if (!is_object($object))
            throw new InvalidArgumentException('Output must be an object.');

        if ($mode == Extractor::EXTRACTION_MODE_METHOD)
            return self::hydrateUsingMethods($object, json_decode($jsonString, true));

        return self::hydrateUsingProperties($object, json_decode($jsonString, true));
    }

    /**
     * @param $object
     * @param array $methods
     * @return bool
     */
    private static function hydrateUsingMethods(&$object, array $methods)
    {
        foreach ($methods as $key => $value) {
            $setterName = 'set' . ucfirst($key);
            $getterName = 'get' . ucfirst($key);
            if (is_array($value)) {
                if (method_exists($object, $getterName))
                    self::hydrateUsingMethods($object->$getterName(), $value);
            } else {
                if (method_exists($object, $setterName))
                    $object->$setterName($value);
            }
        }
        return false;
    }

    /**
     * @param $object
     * @param array $properties
     * @return bool
     */
    private static function hydrateUsingProperties(&$object, array $properties)
    {
        return false;
    }

}