<?php
namespace app\sdk\MyDriver;

abstract class Endpoint
{
    protected $uri;
    protected $method;

    abstract public function run(Request $request);
}