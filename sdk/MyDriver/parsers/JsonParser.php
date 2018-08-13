<?php
namespace app\sdk\MyDriver\parsers;

use app\sdk\MyDriver\exceptions\ParseException;
use Assert\Assertion;

class JsonParser implements ParserInterface
{
    /**
     * @param $body
     * @return array
     * @throws \Assert\AssertionFailedException
     */
    public function parseResponseBody($body)
    {
        $result = json_decode($body, true);
        Assertion::isArray($result, function () {
            throw new ParseException();
        });

        return (array)$result;
    }

    /**
     * @param $object
     * @return string
     * @throws \Assert\AssertionFailedException
     */
    public function prepareRequestBody($object)
    {
        $result = json_encode($object);
        Assertion::true($result !== false, function () {
            throw new ParseException();
        });

        return (string)$result;
    }
}