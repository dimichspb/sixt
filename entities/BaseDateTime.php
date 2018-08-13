<?php
namespace app\entities;

use Assert\Assertion;

abstract class BaseDateTime extends BaseEntity
{
    public function assert($value)
    {
        //Assertion::date($value, 'c');
    }
}