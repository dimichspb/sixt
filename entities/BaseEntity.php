<?php
namespace app\entities;

abstract class BaseEntity
{
    protected $value;

    public function __construct($value = null)
    {
        $this->assert($value);
        $this->value = $value;
    }

    abstract public function assert($value);

    public function getValue()
    {
        return $this->value;
    }
}