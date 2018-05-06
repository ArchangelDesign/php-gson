<?php

use PHPGson\Gson;

include_once 'MainObject.php';

class JsonSerializerTest implements TestInterface
{
    /**
     * @throws ReflectionException
     * @throws Exception
     */
    function runTest()
    {
        $object = new MainObject();
        $result = Gson::toJson($object);
        if ($result != '{"name":"MainObject","address":{"street":"TheStreet","city":"TheCity"},"value":"MainObjectValue"}')
            throw new Exception('Gson did not provide correct JSON string');
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