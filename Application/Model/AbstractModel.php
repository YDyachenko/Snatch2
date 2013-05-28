<?php

namespace Application\Model;

abstract class AbstractModel
{

    protected $data = array();

    /**
     * __get
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            throw new \InvalidArgumentException('Not a valid column in this row: ' . $name);
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    
    public function populate($data)
    {
        $this->data = $data;
        
        return $this;
    }

}