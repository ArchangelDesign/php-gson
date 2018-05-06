<?php

class MainObject
{
    private $name;

    private $address;

    private $value;

    public function __construct()
    {
        $this->name = "MainObject";
        $this->address = new Address();
        $this->value = "MainObjectValue";
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


}