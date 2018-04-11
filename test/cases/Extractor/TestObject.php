<?php

class TestObject {
    private $name = "Raff";

    private $lastName = "Martinez";

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