<?php
namespace app\sdk\MyDriver\http;

use Assert\Assertion;

class HttpMethod
{
    const POST = 'POST';
    const GET = 'GET';

    protected $value;

    /**
     * HttpMethod constructor.
     * @param $value
     */
    public function __construct($value)
    {
        Assertion::inArray($value, [
            self::POST,
            self::GET,
        ]);
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}