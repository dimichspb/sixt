<?php
namespace app\sdk\MyDriver;

abstract class Endpoint
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $method;

    /**
     * @param Request $request
     * @return mixed
     */
    abstract public function run(Request $request);
}