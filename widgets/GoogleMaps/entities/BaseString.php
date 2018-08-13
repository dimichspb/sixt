<?php

namespace app\widgets\GoogleMaps\entities;

use Assert\Assert;
use Assert\Assertion;

abstract class BaseString extends BaseEntity
{
    public function assert($value)
    {
        Assertion::string($value);
    }

}