<?php

namespace Tarcha\WebKernel\Entities;
use \JsonSerializable;

abstract class Abstractentity implements JsonSerializable
{
    /**
     * Remember if any properties have been changed
     */
    private $isDirty = false;

    /**
     * Construct
     */
    public function __construct($data = array())
    {
        $this->setData($data);
    }

    /**
     *
     * Allows for an object to be populated by passign in an array
     * Properties MUST be defined
     *
     * @param array $data an array of data to set
     *
     */
    public function setData($data = array())
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Returns the accessible non-static properties of the given object
     */
    public function getData()
    {
        $properties = get_object_vars($this);
        return $properties;
    }

    /**
     * Returns true if the objects properties have changed
     */
    public function isDirty()
    {
        return $this->isDirty;
    }

    /**
     * setter to access private paroperties
     */
    public function __set($name, $val)
    {
        $this->name = $val;
        $this->isDirty = true;
    }

    /**
     * Getter to read private properties
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Returns an array of properties for json_encode to serialize
     */
    public function jsonSerialize()
    {
        return $this->getData();
    }
}
