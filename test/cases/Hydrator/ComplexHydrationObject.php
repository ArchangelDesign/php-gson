<?php

class ComplexHydrationObject
{
    private $hydratorTestObject;

    private $age;

    /**
     * @return mixed
     */
    public function getHydratorTestObject()
    {
        return $this->hydratorTestObject;
    }

    /**
     * @param mixed $hydratorTestObject
     */
    public function setHydratorTestObject($hydratorTestObject)
    {
        $this->hydratorTestObject = $hydratorTestObject;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }


}