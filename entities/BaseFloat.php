<?php
namespace app\entities;

use Assert\Assertion;

abstract class BaseFloat extends BaseEntity
{
    public function assert($value)
    {
        Assertion::numeric($value);
    }
}