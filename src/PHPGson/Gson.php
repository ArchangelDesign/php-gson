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
use ReflectionException;

class Gson
{
    /**
     * Converts given object to JSON string
     * using either properties or getters (serialize)
     *
     * @param $object
     * @param int $mode
     * @return string
     * @throws ReflectionException
     */
    public static function toJson($object, $mode = Extractor::EXTRACTION_MODE_METHOD)
    {
        if (is_array($object))
            throw new InvalidArgumentException('Input object cannot be an array.');

        if (!is_object($object))
            throw new InvalidArgumentException('Input must be an object.');

        $extractor = new Extractor($object, $mode);
        $dto = $extractor->extract();

        return self::dtoToJson($dto);
    }

    /**
     * Hydrate an object based on the JSON string (deserialize)
     *
     * @param Object|null $object
     * @param string $jsonString
     * @param int $mode
     * @param string $className class to create if object is null
     * @return bool true if success
     */
    public static function fromJson(&$object, $jsonString, $mode = Extractor::EXTRACTION_MODE_METHOD, $className = null)
    {
        return Hydrator::hydrate($object, $jsonString, $mode, $className);
    }

    /**
     * @param DataTransferObject $dto
     * @return string JSON string
     */
    private static function dtoToJson(DataTransferObject $dto)
    {
        if ($dto->getMode() == Extractor::EXTRACTION_MODE_METHOD)
            return self::serializeMethods($dto);

        return self::serializeProperties($dto);
    }

    /**
     * @param DataTransferObject $dto
     * @return string JSON
     */
    private static function serializeMethods(DataTransferObject $dto)
    {
        return json_encode(self::getMethodsValues($dto->toArray()));
    }

    /**
     * @param array $methods
     * @return array
     */
    private static function getMethodsValues(array $methods)
    {
        $result = [];

        foreach ($methods as $name => $value) {
            $fieldName = lcfirst(preg_replace('/^get(?=[A-Z])/', '', $name));
            if (is_array($value))
                $result[$fieldName] = self::getMethodsValues($value);
            else
                $result[$fieldName] = $value;
        }

        return $result;
    }

    /**
     * @param DataTransferObject $dto
     * @return string JSON
     */
    private static function serializeProperties(DataTransferObject $dto)
    {
        return json_encode($dto->toArray());
    }
}