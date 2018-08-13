<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

class Currency extends BaseString
{
    const USD = 'USD';
    const EUR = 'EUR';

    /**
     * @param $value
     * @return mixed|void
     * @throws \Assert\AssertionFailedException
     */
    public function assert($value)
    {
        parent::assert($value);
        Assertion::inArray($value, [
            self::USD,
            self::EUR
        ]);
    }
}