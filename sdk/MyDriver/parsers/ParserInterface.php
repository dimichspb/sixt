<?php
namespace app\sdk\MyDriver\parsers;

interface ParserInterface
{
    public function parseResponseBody($responseBody);
    public function prepareRequestBody($object);
}