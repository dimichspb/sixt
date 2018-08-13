<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

abstract class BaseFloat extends BaseEntity
{
    /**
     * @param $value
     * @return mixed|void
     * @throws \Assert\AssertionFailedException
     */
    public function assert($value)
    {
        Assertion::numeric($value);
    }
}