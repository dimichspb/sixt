<?php

namespace app\entities;

use Assert\Assert;
use Assert\Assertion;

abstract class BaseString extends BaseEntity
{
    public function assert($value)
    {
        Assertion::string($value);
    }

    public function __toString()
    {
        return $this->getValue();
    }
}