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

require_once 'FlatObject.php';

class ComplexObject
{
    private $flatObject = null;

    private $flatObject2 = null;

    public function mock() {
        $this->flatObject = new FlatObject();
        $this->flatObject->mock();
        $this->flatObject2 = new FlatObject();
        $this->flatObject2->mock();
    }

    /**
     * @return null|FlatObject
     */
    public function getFlatObject(): ?FlatObject
    {
        return $this->flatObject;
    }

    /**
     * @param null $flatObject
     */
    public function setFlatObject($flatObject): void
    {
        $this->flatObject = $flatObject;
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