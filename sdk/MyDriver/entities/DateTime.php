<?php
namespace app\sdk\MyDriver\entities;

use app\sdk\MyDriver\entities\base\BaseDateTime;

class DateTime extends BaseDateTime
{
    /**
     * DateTime constructor.
     * @param null $value
     */
    public function __construct($value = null)
    {
        $value = (new \DateTime($value))->format('c');
        parent::__construct($value);
    }
}