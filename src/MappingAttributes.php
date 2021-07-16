<?php

namespace Jotape\Tars;

abstract class MappingAttributes
{
    protected $mapping = [];
    
    public function __construct($attributes) {
        foreach($attributes as $attribute => $value){
            $this->$attribute = $value;
        }
    }

    public function __get($name)
    {
        $mapping_attribute = $this->mapping[$name];
        return $this->$mapping_attribute;
    }

    public function toArray()
    {
        $output = [];

        foreach ($this->mapping as $key => $value) {
            $output[$key] = $this->$key;
        }

        return $output;
    }
}