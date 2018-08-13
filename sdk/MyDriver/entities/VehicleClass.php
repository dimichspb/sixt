<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

class VehicleClass extends BaseString
{
    const ECONOMY_CLASS = 'ECONOMY_CLASS';
    const FIRST_CLASS = 'FIRST_CLASS';
    const BUSINESS_CLASS = 'BUSINESS_CLASS';
    const BUSINESS_VAN = 'BUSINESS_VAN';

    public function assert($value)
    {
        parent::assert($value);

        Assertion::inArray($value, [
            self::ECONOMY_CLASS,
            self::FIRST_CLASS,
            self::BUSINESS_CLASS,
            self::BUSINESS_VAN,
        ]);
    }
}