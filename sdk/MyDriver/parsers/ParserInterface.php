<?php
namespace app\sdk\MyDriver\parsers;

interface ParserInterface
{
    /**
     * @param $responseBody
     * @return mixed
     */
    public function parseResponseBody($responseBody);

    /**
     * @param $object
     * @return mixed
     */
    public function prepareRequestBody($object);
}