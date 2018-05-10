# php-gson
Zero dependency simple PHP entity mapper.
JSON String to Objcet and Object to JSON String.

**Installation**

```
composer require archangeldesign/php-gson
```

or download and include autoload.php

```
include 'php-gson/src/PHPGson/autoload.php';
```

**Usage**

Without instance.
Object will be created using given class name.
```
$complexObject = null;
$success = \PHPGson\Gson::fromJson(
    $complexObject,
    '{"age":35, "hydratorTestObject":{"username":"raff"}}',
    \PHPGson\Extractor::EXTRACTION_MODE_METHOD,
    ComplexHydrationObject::class
);
```

With manual instantiation.
Sub-objects will be created automatically in both cases.

```
$complexObject = new ComplexHydrationObject();
$success = \PHPGson\Gson::fromJson(
    $complexObject,
    '{"age":35, "hydratorTestObject":{"username":"raff"}}'
);
```

```
$object = new MainObject();
$jsonString = Gson::toJson($object);
```
