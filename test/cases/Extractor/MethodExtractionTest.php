<?php

use PHPGson\Extractor;

require ROOT . '/test/abstraction/TestInterface.php';
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

        $dto = $extractor->extract();

        if (count($dto->toArray()) != 2)
            throw new Exception('Expected 2 methods. found ' . count($dto));

        if (!isset($dto->toArray()['getName']))
            throw new Exception('Method getName() not found.');

        if (!isset($dto->toArray()['getLastName']))
            throw new Exception('Method getLastName() not found.');

        if ($dto->getName != 'Raff')
            throw new Exception('Method getName() did not return \'Raff\'');

        if ($dto->getLastName != 'Martinez')
            throw new Exception('Method getLastName() did not return \'Martinez\'');
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