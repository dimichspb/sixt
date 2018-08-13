<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

abstract class BaseString extends BaseEntity
{
    /**
     * @param $value
     * @return mixed|void
     * @throws \Assert\AssertionFailedException
     */
    public function assert($value)
    {
        Assertion::string($value);
    }

}