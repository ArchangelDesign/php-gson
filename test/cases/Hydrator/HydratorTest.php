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
        $hydrator = new Hydrator('{"username":"archangel"}');
        $object = new HydratorTestObject();
        $hydrator->hydrate($object);
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