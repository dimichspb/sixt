<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

class ApiKey extends BaseString
{
    /**
     * @param $value
     * @throws \Assert\AssertionFailedException
     */
    public function assert($value)
    {
        parent::assert($value);
        Assertion::length($value, 20);
    }
}