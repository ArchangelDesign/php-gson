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

require 'entity/FlatObject.php';

use PHPGson\Extractor;
use PHPGson\Gson;
use PHPUnit\Framework\TestCase;

class FlatObjectTest extends TestCase
{

    private $flatObject;
    private $jsonString;

    protected function setUp(): void
    {
        $this->flatObject = new FlatObject();
        $this->flatObject->mock();
        $this->jsonString = Gson::toJson($this->flatObject);
    }

    public function testObjectHydration(): void
    {
        $deserialized = json_decode($this->jsonString, true);
        /** @noinspection PhpParamsInspection */
        $this->assertCount(4, $deserialized);
        $this->assertArrayHasKey('languages', $deserialized);
        /** @noinspection PhpParamsInspection */
        $this->assertCount(5, $deserialized['languages']);

        $hydrated = new FlatObject();
        Gson::fromJson($hydrated, $this->jsonString);
        $this->assertEquals('my-email@gmail.com', $hydrated->getEmail());
        $this->assertEquals('225 Baker Street', $hydrated->getAddress());
        $this->assertEquals('123 123 123', $hydrated->getPhoneNumber());
        $this->assertIsArray($hydrated->getLanguages());
    }

    public function testObjectInstantiation() {
        $hydrated = null;
        Gson::fromJson(
            $hydrated,
            $this->jsonString,
            Extractor::EXTRACTION_MODE_METHOD,
            FlatObject::class);
        /** @noinspection PhpParamsInspection */
        $this->assertInstanceOf(FlatObject::class, $hydrated);
    }
}