<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

class Type extends BaseString
{
    const DISTANCE = 'DISTANCE';
    const DURATION = 'DURATION';

    /**
     * @param $value
     * @return mixed|void
     * @throws \Assert\AssertionFailedException
     */
    public function assert($value)
    {
        parent::assert($value);
        Assertion::inArray($value, [
            self::DISTANCE,
            self::DURATION
        ]);
    }

}