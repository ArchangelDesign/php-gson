<?php

require_once 'FlatObject.php';

class ComplexObject
{
    private $flatObject1 = null;

    private $flatObject2 = null;

    public function mock() {
        $this->flatObject1 = new FlatObject();
        $this->flatObject1->mock();
        $this->flatObject2 = new FlatObject();
        $this->flatObject2->mock();
    }

    /**
     * @return null|FlatObject
     */
    public function getFlatObject1(): ?FlatObject
    {
        return $this->flatObject1;
    }

    /**
     * @param null $flatObject1
     */
    public function setFlatObject1($flatObject1): void
    {
        $this->flatObject1 = $flatObject1;
    }

    /**
     * @return null|FlatObject
     */
    public function getFlatObject2(): ?FlatObject
    {
        return $this->flatObject2;
    }

    /**
     * @param null $flatObject2
     */
    public function setFlatObject2($flatObject2): void
    {
        $this->flatObject2 = $flatObject2;
    }


}