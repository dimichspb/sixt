<?php
namespace app\sdk\MyDriver\tests\unit\endpoints;

use app\sdk\MyDriver\endpoints\Offers;
use app\sdk\MyDriver\entities\ApiKey;
use app\sdk\MyDriver\entities\Currency;
use app\sdk\MyDriver\entities\DateTime;
use app\sdk\MyDriver\entities\PlaceName;
use app\sdk\MyDriver\entities\Type;
use app\sdk\MyDriver\entities\VehicleClass;
use app\sdk\MyDriver\http\HttpClient;
use app\sdk\MyDriver\Offer;
use app\sdk\MyDriver\OffersRequest;
use app\sdk\MyDriver\parsers\ParserInterface;
use Codeception\Test\Unit;
use Psr\Http\Message\ResponseInterface;

class OffersTest extends Unit
{
    protected $data = [
        [
            'amount' => 100,
            'currency' => 'EUR',
            'vehicleType' => [
                'name' => 'ECONOMY_CLASS',
            ],
        ],
        [
            'amount' => 100,
            'currency' => 'EUR',
            'vehicleType' => [
                'name' => 'ECONOMY_CLASS',
            ],
        ],
        [
            'amount' => 100,
            'currency' => 'EUR',
            'vehicleType' => [
                'name' => 'ECONOMY_CLASS',
            ],
        ],
        [
            'amount' => 100,
            'currency' => 'EUR',
            'vehicleType' => [
                'name' => 'ECONOMY_CLASS',
            ],
        ],
    ];

    public function testRunSuccess()
    {
        $offersEndpoint = new Offers($this->getApiKeyMock(), $this->getHttpClientMock(), $this->getParserMock());

        $offers = $offersEndpoint->run($this->getRequestMock());

        expect(count($offers))->equals(4);
        expect($offers)->containsOnlyInstancesOf(Offer::class);

        foreach ($offers as $offer) {
            expect($offer->getVehicleClass()->getValue())->equals(VehicleClass::ECONOMY_CLASS);
            expect($offer->getPrice()->getValue())->equals(100);
            expect($offer->getCurrency()->getValue())->equals(Currency::EUR);
        }
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
        $httpResponse->method('getBody')->willReturn(json_encode($this->data));

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
        $parser->method('parseResponseBody')->willReturn($this->data);

        return $parser;
    }

    /**
     * @return OffersRequest
     */
    protected function getRequestMock()
    {
        $origin = $this->getMockBuilder(PlaceName::class)->setConstructorArgs([
            'value' => 'Origin',
        ])->getMock();
        $origin->method('getValue')->willReturn('Origin');

        $destination = $this->getMockBuilder(PlaceName::class)->setConstructorArgs([
            'value' => 'Destination',
        ])->getMock();
        $destination->method('getValue')->willReturn('Destination');

        $dateTime = $this->getMockBuilder(DateTime::class)->setConstructorArgs([
            'value' => '2018-08-14T08:20:24+00:00',
        ])->getMock();
        $dateTime->method('getValue')->willReturn('2018-08-14T08:20:24+00:00');

        $type = $this->getMockBuilder(Type::class)->setConstructorArgs([
            'value' => Type::DISTANCE,
        ])->getMock();
        $type->method('getValue')->willReturn(Type::DISTANCE);

        $request = $this->getMockBuilder(OffersRequest::class)->setConstructorArgs([
            'origin' => $origin,
            'destination' => $destination,
            'dateTime' => $dateTime,
            'type' => $type,
        ])->getMock();
        $request->method('getOrigin')->willReturn($origin);
        $request->method('getDestination')->willReturn($destination);
        $request->method('getDateTime')->willReturn($dateTime);
        $request->method('getType')->willReturn($type);

        return $request;
    }
}