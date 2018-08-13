<?php
namespace app\sdk\MyDriver\entities;

abstract class BaseDecimal extends BaseFloat
{
    public function getValue()
    {
        return round(parent::getValue(), 2);
    }
}