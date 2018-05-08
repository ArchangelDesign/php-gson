<?php

use PHPGson\Hydrator;

include_once 'HydratorTestObject.php';

class HydratorTest implements TestInterface
{
    /**
     * @throws Exception
     */
    function runTest()
    {
        $object = new HydratorTestObject();
        Hydrator::hydrate($object, '{"username":"archangel"}');
        if ($object->getUsername() != 'archangel')
            throw new Exception('Hydration failed.');
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