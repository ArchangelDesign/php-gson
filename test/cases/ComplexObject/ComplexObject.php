<?php

class ComplexObject
{
    public function getName()
    {
        return "TheName";
    }

    public function getAddress()
    {
        return new Address();
    }
}