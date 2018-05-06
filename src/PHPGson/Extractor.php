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
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Class Extractor
 * Used to extract methods and properties
 * from given object
 *
 * @package PHPGson
 */
class Extractor
{
    /**
     * Extract properties
     */
    const EXTRACTION_MODE_PROPERTY = 1;

    /**
     * Extract methods
     */
    const EXTRACTION_MODE_METHOD = 2;

    /**
     * @var Object to extract from
     */
    private $object;

    /**
     * @var int Extraction mode
     */
    private $mode;

    /**
     * @var ReflectionClass
     */
    private $reflection;

    /**
     * Extractor constructor.
     * @param $object
     * @param int $mode
     * @throws \ReflectionException
     */
    public function __construct($object, $mode = self::EXTRACTION_MODE_PROPERTY)
    {
        if (is_array($object))
            throw new InvalidArgumentException(
                'Input object cannot be an array'
            );

        $this->object = $object;
        $this->mode = $mode;
        $this->reflection = new ReflectionClass($this->object);
    }

    /**
     * Returns objects methods or properties
     * as a DataTransferObject
     *
     * @return DataTransferObject
     * @throws \ReflectionException
     */
    public function extract()
    {
        $result = new DataTransferObject();

        $fields = [];

        switch ($this->mode) {
            case self::EXTRACTION_MODE_PROPERTY:
                $fields = $this->extractProperties($this->object);
                break;
            case self::EXTRACTION_MODE_METHOD:
                $fields = $this->extractGetters($this->object);
                break;
        }

        foreach ($fields as $name => $field) {
            $result->addField($name, $field['value']);
        }

        return $result;
    }

    /**
     * Returns an associative array of getters
     * where key is the name of the method
     *
     * @param $object
     * @return array
     * @throws \ReflectionException
     */
    private function extractGetters($object)
    {
        $methods = $this->getMethods($object);

        $resultArray = [];

        foreach ($methods as $method) {
            if (preg_match('/^get[A-Z]/', $method->getName())) {
                $methodName = $method->getName();
                if (is_object($object->$methodName())) {
                    $resultArray[$method->getName()] = [
                        'value' => $this->extractGetters($object->$methodName())
                    ];
                } else {
                    $resultArray[$method->getName()] = [
                        'value' => $object->$methodName()
                    ];
                }
            }
        }

        return $resultArray;
    }

    /**
     * Returns an associative array of properties
     * where key is the name of the property
     *
     * @param $object
     * @return array
     * @throws \ReflectionException
     */
    private function extractProperties($object)
    {
        $properties = $this->getProperties($object);

        $resultArray = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);

            $resultArray[$property->getName()] = [
                'value' => $property->getValue(),
                'isMethod' => false,
            ];
        }

        return $resultArray;
    }

    /**
     * @param $object
     * @return ReflectionProperty[]
     * @throws \ReflectionException
     */
    private function getProperties($object)
    {
        $reflection = new ReflectionClass($object);
        return $reflection->getProperties();
    }

    /**
     * @param $object
     * @return ReflectionMethod[]
     * @throws \ReflectionException
     */
    private function getMethods($object)
    {
        $reflection = new ReflectionClass($object);
        return $reflection->getMethods();
    }

    /**
     * @param $methodName
     * @return ReflectionMethod
     */
    private function getMethod($methodName)
    {
        return $this->reflection->getMethod($methodName);
    }
}