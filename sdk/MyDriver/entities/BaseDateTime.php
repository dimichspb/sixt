<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

abstract class BaseDateTime extends BaseEntity
{
    public function assert($value)
    {
        //Assertion::date($value, 'c');
    }
}