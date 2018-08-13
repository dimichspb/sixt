<?php
namespace app\entities;

class DateTime extends BaseDateTime
{
    public function __construct($value = null)
    {
        $value = (new \DateTime($value))->format('c');
        parent::__construct($value);
    }
}