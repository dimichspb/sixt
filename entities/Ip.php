<?php
namespace app\entities;

use app\entities\base\BaseString;
use Assert\Assertion;

class Ip extends BaseString
{
    public function assert($value)
    {
        Assertion::ip($value);
        parent::assert($value);
    }
}