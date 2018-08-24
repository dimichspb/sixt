<?php
namespace app\entities\VehicleClass;

use app\entities\base\BaseString;
use Assert\Assertion;

class VehicleClass extends BaseString
{
    const ECONOMY_CLASS = 'ECONOMY_CLASS';
    const FIRST_CLASS = 'FIRST_CLASS';
    const BUSINESS_CLASS = 'BUSINESS_CLASS';
    const BUSINESS_VAN = 'BUSINESS_VAN';

    /**
     * @param $value
     * @return mixed|void
     * @throws \Assert\AssertionFailedException
     */
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