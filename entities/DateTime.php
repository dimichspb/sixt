<?php
namespace app\entities;

use app\entities\base\BaseDateTime;

class DateTime extends BaseDateTime
{
    /**
     * DateTime constructor.
     * @param null $value
     */
    public function __construct($value = null)
    {
        $value = (new \DateTime($value))->format('Y-m-d H:i');
        parent::__construct($value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}