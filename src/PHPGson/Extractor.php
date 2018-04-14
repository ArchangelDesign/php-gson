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
     */
    public function extract()
    {
        $result = new DataTransferObject();

        $fields = [];

        switch ($this->mode) {
            case self::EXTRACTION_MODE_PROPERTY:
                $fields = $this->extractProperties();
                break;
            case self::EXTRACTION_MODE_METHOD:
                $fields = $this->extractGetters();
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
     * @return array
     */
    private function extractGetters()
    {
        $methods = $this->getMethods();

        $resultArray = [];

        foreach ($methods as $method) {
            if (preg_match('/^get[A-Z]/', $method->getName())) {
                $method = $this->getMethod($method->getName());
                $method->setAccessible(true);

                $resultArray[$method->getName()] = [
                    'value' => $method->invoke($this->object)
                ];
            }
        }

        return $resultArray;
    }

    /**
     * Returns an associative array of properties
     * where key is the name of the property
     *
     * @return array
     */
    private function extractProperties()
    {
        $properties = $this->getProperties();

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
     * @return ReflectionProperty[]
     */
    private function getProperties()
    {
        return $this->reflection->getProperties();
    }

    /**
     * @return ReflectionMethod[]
     */
    private function getMethods()
    {
        return $this->reflection->getMethods();
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