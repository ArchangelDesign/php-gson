# php-gson
Zero dependency simple PHP entity mapper.
JSON String to Objcet and Object to JSON String.

```
$complexObject = null;
$success = \PHPGson\Gson::fromJson(
    $complexObject,
    '{"age":35, "hydratorTestObject":{"username":"raff"}}',
    \PHPGson\Extractor::EXTRACTION_MODE_METHOD,
    ComplexHydrationObject::class
);
```

```
$object = new MainObject();
$jsonString = Gson::toJson($object);
```