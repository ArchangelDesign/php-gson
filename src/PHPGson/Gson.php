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
     * @param DataTransferObject $dto
     * @return string JSON string
     */
    private static function dtoToJson(DataTransferObject $dto)
    {
        return json_encode($dto->toArray());
    }
}