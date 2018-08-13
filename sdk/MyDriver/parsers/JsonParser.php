<?php
namespace app\sdk\MyDriver\parsers;

use app\sdk\MyDriver\exceptions\ParseException;
use Assert\Assertion;

class JsonParser implements ParserInterface
{
    public function parseResponseBody($body)
    {
        $result = json_decode($body, true);
        Assertion::isArray($result, function () {
            throw new ParseException();
        });

        return (array)$result;
    }

    public function prepareRequestBody($object)
    {
        $result = json_encode($object);
        Assertion::true($result !== false, function () {
            throw new ParseException();
        });

        return (string)$result;
    }
}