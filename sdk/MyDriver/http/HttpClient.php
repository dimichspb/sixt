<?php
namespace app\sdk\MyDriver\http;

use GuzzleHttp\Client;
use app\sdk\MyDriver\http\HttpClientInterface as ClientInterface;
use Psr\Http\Message\RequestInterface;

class HttpClient extends Client implements ClientInterface
{
    public function sendRequest(RequestInterface $request)
    {
        return $this->send($request);
    }
}