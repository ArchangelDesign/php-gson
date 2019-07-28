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

use PHPGson\Extractor;
use PHPGson\Gson;
use PHPUnit\Framework\TestCase;

require_once 'entity/ComplexObject.php';

class ComplexObjectTest extends TestCase
{
    private $complexObject;

    private $jsonString;

    protected function setUp(): void
    {
        $this->complexObject = new ComplexObject();
        $this->complexObject->mock();
        $this->jsonString = Gson::toJson($this->complexObject);
    }

    public function testObjectSerialization(): void
    {
        $deserialized = json_decode($this->jsonString, true);
        $this->assertArrayHasKey('flatObject', $deserialized);
        $this->assertArrayHasKey('flatObject2', $deserialized);
        $this->assertIsArray($deserialized['flatObject']);
        $this->assertIsArray($deserialized['flatObject2']);
        $this->assertArrayHasKey('email', $deserialized['flatObject']);
        $this->assertArrayHasKey('email', $deserialized['flatObject2']);
        $this->assertArrayHasKey('address', $deserialized['flatObject']);
        $this->assertArrayHasKey('address', $deserialized['flatObject2']);
        $this->assertArrayHasKey('phoneNumber', $deserialized['flatObject']);
        $this->assertArrayHasKey('phoneNumber', $deserialized['flatObject2']);
        $this->assertArrayHasKey('languages', $deserialized['flatObject']);
        $this->assertArrayHasKey('languages', $deserialized['flatObject2']);
        $this->assertIsArray($deserialized['flatObject']['languages']);
        $this->assertIsArray($deserialized['flatObject2']['languages']);
        $this->assertEquals('my-email@gmail.com', $deserialized['flatObject']['email']);
        $this->assertEquals('my-email@gmail.com', $deserialized['flatObject2']['email']);
        $this->assertEquals('225 Baker Street', $deserialized['flatObject']['address']);
        $this->assertEquals('225 Baker Street', $deserialized['flatObject2']['address']);
        $this->assertEquals('123 123 123', $deserialized['flatObject']['phoneNumber']);
        $this->assertEquals('123 123 123', $deserialized['flatObject2']['phoneNumber']);
        /** @noinspection PhpParamsInspection */
        $this->assertCount(5, $deserialized['flatObject']['languages']);
        /** @noinspection PhpParamsInspection */
        $this->assertCount(5, $deserialized['flatObject2']['languages']);
    }

    public function testObjectHydration(): void
    {
        $hydrated = null;

        Gson::fromJson(
            $hydrated,
            $this->jsonString,
            Extractor::EXTRACTION_MODE_METHOD,
            ComplexObject::class);

        /** @noinspection PhpParamsInspection */
        $this->assertInstanceOf(FlatObject::class, $hydrated->getFlatObject());
    }
}