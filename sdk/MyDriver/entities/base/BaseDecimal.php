<?php
namespace app\sdk\MyDriver\entities\base;

abstract class BaseDecimal extends BaseFloat
{
    /**
     * @return float|null
     */
    public function getValue()
    {
        return round(parent::getValue(), 2);
    }
}