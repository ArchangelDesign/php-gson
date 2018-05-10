<?php

use PHPGson\Hydrator;

include_once 'HydratorTestObject.php';
include_once 'ComplexHydrationObject.php';

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
        $complexObject = null;
        Hydrator::hydrate(
            $complexObject,
            '{"age":35, "hydratorTestObject":{"username":"raff"}}',
            \PHPGson\Extractor::EXTRACTION_MODE_METHOD,
            ComplexHydrationObject::class
        );
        if ($complexObject->getAge() !== 35)
            throw new Exception("Hydration failed. Expected 35 got {$complexObject->getAge()}");

        if (!method_exists($complexObject, 'getHydratorTestObject'))
            throw new Exception('Hydration failed. Method getHydratorTestObject() does not exist');

        if ($complexObject->getHydratorTestObject() == null)
            throw new Exception('Hydration failed. Sub-object has not been created.');

        if (!method_exists($complexObject->getHydratorTestObject(), 'getUsername'))
            throw new Exception('Method getUsername() does not exist');

        if ($complexObject->getHydratorTestObject()->getUsername() !== 'raff')
            throw new Exception("Hydration failed. Expected 'raff' got '{$complexObject->getHydrationTestObject()->getUsername()}'");
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