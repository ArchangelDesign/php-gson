<?php

use PHPGson\Extractor;

require_once ROOT . '/test/abstraction/TestInterface.php';

class ComplexObjectTest implements TestInterface
{
    /**
     * @throws ReflectionException
     * @throws Exception
     */
    function runTest()
    {
        $extractor = new Extractor(
            new ComplexObject(),
            Extractor::EXTRACTION_MODE_METHOD
        );

        $methods = $extractor->extract()->toArray();

        if (!isset($methods['getName']))
            throw new Exception('Method getName() has not been extracted');

        if (!isset($methods['getAddress']))
            throw new Exception('Method getAddress() has not been extracted');

        if (!is_array($methods['getAddress']))
            throw new Exception('Method getAddress() should return an array');

        if (!isset($methods['getAddress']['getCity']))
            throw new Exception('Method getAddress()->getCity() has not been extracted');


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