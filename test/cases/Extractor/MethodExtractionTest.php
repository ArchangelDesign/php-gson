<?php

use PHPGson\Extractor;

require ROOT . '/test/abstraction/TestInterface.php';
require ROOT . '/src/PHPGson/Extractor.php';
require 'TestObject.php';

class MethodExtractionTest implements TestInterface
{
    /**
     * @throws ReflectionException
     * @throws Exception
     */
    function runTest()
    {
        $extractor = new Extractor(
            new TestObject(),
            Extractor::EXTRACTION_MODE_METHOD
        );

        $methods = $extractor->toArray();

        if (count($methods) != 2)
            throw new Exception('Expected 2 methods. found ' . count($methods));

        if (!isset($methods['getName']))
            throw new Exception('Method getName() not found.');

        if (!isset($methods['getLastName']))
            throw new Exception('Method getLastName() not found.');


    }

    function isEnabled()
    {
        return true;
    }

    function getTitle()
    {
        return self::class;
    }


}