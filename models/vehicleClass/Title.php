<?php
namespace app\models\vehicleClass;

use app\entities\base\BaseString;
use Assert\Assertion;

class Title extends BaseString
{
    public function assert($value)
    {
        Assertion::maxLength($value, 255);

        parent::assert($value);
    }
}