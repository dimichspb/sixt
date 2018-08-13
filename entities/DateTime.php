<?php
namespace app\entities;

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

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}