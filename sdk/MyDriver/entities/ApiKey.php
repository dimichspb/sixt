<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;
use app\sdk\MyDriver\entities\base\BaseString;

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