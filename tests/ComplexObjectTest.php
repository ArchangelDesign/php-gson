<?php


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
        $this->assertArrayHasKey('flatObject1', $deserialized);
        $this->assertArrayHasKey('flatObject2', $deserialized);
        $this->assertIsArray($deserialized['flatObject1']);
        $this->assertIsArray($deserialized['flatObject2']);
        $this->assertArrayHasKey('email', $deserialized['flatObject1']);
        $this->assertArrayHasKey('email', $deserialized['flatObject2']);
        $this->assertArrayHasKey('address', $deserialized['flatObject1']);
        $this->assertArrayHasKey('address', $deserialized['flatObject2']);
        $this->assertArrayHasKey('phoneNumber', $deserialized['flatObject1']);
        $this->assertArrayHasKey('phoneNumber', $deserialized['flatObject2']);
        $this->assertArrayHasKey('languages', $deserialized['flatObject1']);
        $this->assertArrayHasKey('languages', $deserialized['flatObject2']);
        $this->assertIsArray($deserialized['flatObject1']['languages']);
        $this->assertIsArray($deserialized['flatObject2']['languages']);
        $this->assertEquals('my-email@gmail.com', $deserialized['flatObject1']['email']);
        $this->assertEquals('my-email@gmail.com', $deserialized['flatObject2']['email']);
        $this->assertEquals('225 Baker Street', $deserialized['flatObject1']['address']);
        $this->assertEquals('225 Baker Street', $deserialized['flatObject2']['address']);
        $this->assertEquals('123 123 123', $deserialized['flatObject1']['phoneNumber']);
        $this->assertEquals('123 123 123', $deserialized['flatObject2']['phoneNumber']);
        /** @noinspection PhpParamsInspection */
        $this->assertCount(5, $deserialized['flatObject1']['languages']);
        /** @noinspection PhpParamsInspection */
        $this->assertCount(5, $deserialized['flatObject2']['languages']);
    }
}