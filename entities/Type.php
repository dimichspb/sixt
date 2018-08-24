<?php
namespace app\entities;

use Assert\Assertion;
use app\entities\base\BaseString;

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