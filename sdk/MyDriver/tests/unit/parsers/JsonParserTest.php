<?php
namespace app\sdk\MyDriver\tests\unit\parsers;

use app\sdk\MyDriver\exceptions\ParseException;
use app\sdk\MyDriver\parsers\JsonParser;
use Codeception\Test\Unit;

class JsonParserTest extends Unit
{
    /**
     * @throws \Assert\AssertionFailedException
     */
    public function testParseResponseBodySuccess()
    {
        $parser = new JsonParser();

        expect($parser->parseResponseBody('[{"value":100}]'))->equals([['value' => 100]]);
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    public function testPrepareRequestBodySuccess()
    {
        $parser = new JsonParser();

        $object = new \stdClass();
        $object->value = 100;

        expect($parser->prepareRequestBody([$object]))->equals('[{"value":100}]');
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    public function testParseResponseBodyFailed()
    {
        $this->expectException(ParseException::class);

        $parser = new JsonParser();

        expect($parser->parseResponseBody('[{"value":100]'))->equals([['value' => 100]]);
    }
}