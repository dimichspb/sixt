<?php
namespace app\sdk\MyDriver\tests\unit;

use app\sdk\MyDriver\endpoints\Offers;
use app\sdk\MyDriver\entities\ApiKey;
use app\sdk\MyDriver\http\HttpClient;
use app\sdk\MyDriver\MyDriver;
use app\sdk\MyDriver\parsers\ParserInterface;
use Codeception\Test\Unit;
use Psr\Http\Message\ResponseInterface;

class MyDriverTest extends Unit
{
    public function testCreateSuccess()
    {
        $myDriver = new MyDriver($this->getApiKeyMock(), $this->getHttpClientMock(), $this->getParserMock());

        expect($myDriver->offers())->isInstanceOf(Offers::class);
    }

    /**
     * @return ApiKey
     */
    protected function getApiKeyMock()
    {
        $apiKey = $this->getMockBuilder(ApiKey::class)->getMock();

        return $apiKey;
    }

    /**
     * @return HttpClient
     */
    protected function getHttpClientMock()
    {
        $httpResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $httpClient = $this->getMockBuilder(HttpClient::class)->getMock();
        $httpClient->method('sendRequest')->willReturn($httpResponse);

        return $httpClient;
    }


    /**
     * @return ParserInterface
     */
    protected function getParserMock()
    {
        $parser = $this->getMockBuilder(ParserInterface::class)->getMock();

        return $parser;
    }
}