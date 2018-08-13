<?php
namespace app\sdk\MyDriver\entities;

use Assert\Assertion;

class Type extends BaseString
{
    const DISTANCE = 'DISTANCE';
    const DURATION = 'DURATION';

    public function assert($value)
    {
        parent::assert($value);
        Assertion::inArray($value, [
            self::DISTANCE,
            self::DURATION
        ]);
    }

}