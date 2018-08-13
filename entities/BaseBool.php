<?php

namespace app\entities;

use Assert\Assertion;

abstract class BaseBool extends BaseEntity
{
    /**
     * @param $value
     * @throws \Assert\AssertionFailedException
     */
    public function assert($value)
    {
        Assertion::boolean($value);
    }

}