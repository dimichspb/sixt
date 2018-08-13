<?php

namespace app\sdk\MyDriver\entities;

use Assert\Assert;
use Assert\Assertion;

abstract class BaseString extends BaseEntity
{
    public function assert($value)
    {
        Assertion::string($value);
    }

}