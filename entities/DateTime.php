<?php
namespace app\entities;

class DateTime extends BaseDateTime
{
    public function __construct($value = null)
    {
        $value = (new \DateTime($value))->format('c');
        parent::__construct($value);
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}