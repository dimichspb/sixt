<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

class ApiKey extends BaseString
{
    public function assert($value)
    {
        parent::assert($value);
        Assertion::length($value, 20);
    }
}