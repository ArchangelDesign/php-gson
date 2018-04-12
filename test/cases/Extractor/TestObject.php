<?php

class TestObject {

    private $name = "Raff";

    private $lastName = "Martinez";

    private $propertyWithoutGetter = 'propertyWithoutGetter';

    protected $protectedProperty = 'protectedProperty';

    public $publicProperty = 'publicProperty';

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}