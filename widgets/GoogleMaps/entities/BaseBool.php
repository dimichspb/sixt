<?php

namespace app\widgets\GoogleMaps\entities;

use Assert\Assert;
use Assert\Assertion;

abstract class BaseBool extends BaseEntity
{
    public function assert($value)
    {
        Assertion::boolean($value);
    }

}