<?php
namespace app\sdk\MyDriver;

use app\sdk\MyDriver\endpoints\Offers;
use app\sdk\MyDriver\entities\ApiKey;
use app\sdk\MyDriver\parsers\ParserInterface;
use app\sdk\MyDriver\http\HttpClientInterface as ClientInterface;

class MyDriver
{
    protected $apiKey;
    protected $parser;
    protected $httpClient;

    protected $offers;


    public function __construct(ApiKey $apiKey, ClientInterface $httpClient, ParserInterface $parser)
    {
        $this->apiKey = $apiKey;
        $this->parser = $parser;
        $this->httpClient = $httpClient;

        $this->offers = new Offers($this->apiKey, $this->httpClient, $this->parser);
    }

    public function offers()
    {
        return $this->offers;
    }
}