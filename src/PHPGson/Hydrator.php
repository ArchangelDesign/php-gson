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
     * @param null $className
     * @return bool
     */
    public static function hydrate(&$object, $jsonString, $mode = Extractor::EXTRACTION_MODE_METHOD, $className = null)
    {
        if (is_null(json_decode($jsonString)))
            throw new InvalidArgumentException('Invalid JSON string provided');

        if (!is_null($className) && class_exists($className))
            if (is_null($object))
                $object = new $className();

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
                if (method_exists($object, $getterName)) {
                    self::createObjectIfNull($object, $getterName, $setterName, $key);
                    self::hydrateUsingMethods($object->$getterName(), $value);
                }
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

    /**
     * Used for sub-objects of the entity being hydrated
     * Takes reference to the object being hydrated and creates
     * and creates object using setter method
     *
     * @param $object object being hydrated
     * @param $getterName string getter method
     * @param $setterName string setter method
     * @param $className string a key from input JSON string
     */
    private static function createObjectIfNull(&$object, $getterName, $setterName, $className)
    {
        if (empty($className))
            return;
        if (!class_exists($className))
            throw new InvalidArgumentException("Given class {$className} does not exist.");
        $className = ucfirst($className);
        if ($object->$getterName() == null)
            $object->$setterName(new $className());
    }

}