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

class Extractor
{
    const EXTRACTION_MODE_PROPERTY = 1;
    const EXTRACTION_MODE_METHOD = 2;

    private $object;
    private $mode;

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

    public function toArray()
    {
        switch ($this->mode) {
            case self::EXTRACTION_MODE_PROPERTY:
                break;
            case self::EXTRACTION_MODE_METHOD:
                return $this->extractGetters();
                break;
        }
    }

    private function extractGetters()
    {
        $methods = $this->getMethods();

        $resultArray = [];

        foreach ($methods as $method) {
            if (preg_match('/^get[A-Z]/', $method->getName())) {
                $method = $this->getMethod($method->getName());
                $method->setAccessible(true);

                $resultArray[$method->getName()] = [
                    'closure' => $method->getClosure($this->object),
                    'isAbstract' => $method->isAbstract(),
                ];
            }
        }

        return $resultArray;
    }

    private function getProperties()
    {
        return $this->reflection->getProperties();
    }

    private function getMethods()
    {
        return $this->reflection->getMethods();
    }

    private function getMethod($methodName)
    {
        return $this->reflection->getMethod($methodName);
    }
}