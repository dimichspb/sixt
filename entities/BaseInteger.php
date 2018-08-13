<?php
namespace app\entities;

use Assert\Assertion;

abstract class BaseInteger extends BaseEntity
{
    public function assert($value)
    {
        Assertion::integer($value);
    }
}