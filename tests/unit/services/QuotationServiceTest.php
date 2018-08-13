<?php
namespace app\tests\unit\services;

use app\entities\Commission;
use app\entities\Currency;
use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Quotation;
use app\entities\Type;
use app\entities\VehicleClass;
use app\forms\RequestForm;
use app\sdk\MyDriver\endpoints\Offers;
use app\sdk\MyDriver\entities\ApiKey;
use app\sdk\MyDriver\http\HttpClient;
use app\sdk\MyDriver\MyDriver;
use app\sdk\MyDriver\Offer;
use app\sdk\MyDriver\parsers\JsonParser;
use app\services\quotation\QuotationService;
use Codeception\Test\Unit;

class QuotationServiceTest extends Unit
{
    /**
     * @throws \Psr\Http\Client\ClientException
     */
    public function testGetQuotationsSuccess()
    {
        $quotationService = new QuotationService($this->getMyDriverMock(), $this->getCommissionMock());

        $quotations = $quotationService->getQuotations($this->getRequestFormMock());

        expect(count($quotations))->equals(4);
        expect($quotations)->containsOnlyInstancesOf(Quotation::class);
        foreach ($quotations as $quotation) {
            expect($quotation->getCurrency()->getValue())->equals(Currency::EUR);
            expect($quotation->getOffer()->getPrice()->getValue())->equals(100);
            expect($quotation->getPrice()->getValue())->equals(200);
            expect($quotation->getVehicleClass()->getValue())->equals(VehicleClass::ECONOMY_CLASS);
        }
    }

    /**
     * @return MyDriver
     */
    protected function getMyDriverMock()
    {
        $apiKey = $this->getMockBuilder(ApiKey::class)->getMock();
        $httpClient = $this->getMockBuilder(HttpClient::class)->getMock();
        $parser = $this->getMockBuilder(JsonParser::class)->getMock();

        $vehicleClass = $this->getMockBuilder(\app\sdk\MyDriver\entities\VehicleClass::class)->setConstructorArgs([
            'value' => \app\sdk\MyDriver\entities\VehicleClass::ECONOMY_CLASS,
        ])->getMock();
        $vehicleClass->method('getValue')->willReturn(\app\sdk\MyDriver\entities\VehicleClass::ECONOMY_CLASS);

        $price = $this->getMockBuilder(\app\sdk\MyDriver\entities\Price::class)->setConstructorArgs([
            'value' => 100,
        ])->getMock();
        $price->method('getValue')->willReturn(100);

        $currency = $this->getMockBuilder(\app\sdk\MyDriver\entities\Currency::class)->setConstructorArgs([
            'value' => \app\sdk\MyDriver\entities\Currency::EUR,
        ])->getMock();
        $currency->method('getValue')->willReturn(\app\sdk\MyDriver\entities\Currency::EUR);


        $offer = $this->getMockBuilder(Offer::class)->setConstructorArgs([
            'vehicleClass' => $vehicleClass,
            'price' => $price,
            'currency' => $currency,
        ])->getMock();
        $offer->method('getVehicleClass')->willReturn($vehicleClass);
        $offer->method('getPrice')->willReturn($price);
        $offer->method('getCurrency')->willReturn($currency);

        $offers = $this->getMockBuilder(Offers::class)->setConstructorArgs([
            'apiKey' => $apiKey,
            'httpClient' => $httpClient,
            'parser' => $parser,
        ])->getMock();

        $offers->method('run')->willReturn([
            $offer,
            $offer,
            $offer,
            $offer
        ]);

        $myDriver = $this->getMockBuilder(MyDriver::class)->setConstructorArgs([
            'apiKey' => $apiKey,
            'httpClient' => $httpClient,
            'parser' => $parser,
        ])->getMock();

        $myDriver->method('offers')->willReturn($offers);

        return $myDriver;
    }

    /**
     * @return Commission
     */
    protected function getCommissionMock()
    {
        $commission = $this->getMockBuilder(Commission::class)->setConstructorArgs([
            'value' => 100,
        ])->getMock();
        $commission->method('getValue')->willReturn(100);

        return $commission;
    }

    /**
     * @return RequestForm
     */
    protected function getRequestFormMock()
    {
        $origin = $this->getMockBuilder(PlaceName::class)->setConstructorArgs([
            'value' => 'Origin',
        ])->getMock();
        $origin->method('getValue')->willReturn('Origin');

        $destination = $this->getMockBuilder(PlaceName::class)->setConstructorArgs([
            'value' => 'Destination',
        ])->getMock();
        $destination->method('getValue')->willReturn('Destination');

        $startDateTime = $this->getMockBuilder(DateTime::class)->setConstructorArgs([
            'value' => '2018-08-14T08:20:24+00:00',
        ])->getMock();
        $startDateTime->method('getValue')->willReturn('2018-08-14T08:20:24+00:00');

        $type = $this->getMockBuilder(Type::class)->setConstructorArgs([
            'value' => Type::DISTANCE,
        ])->getMock();
        $type->method('getValue')->willReturn(Type::DISTANCE);

        $requestForm = $this->getMockBuilder(RequestForm::class)->setConstructorArgs([
            'origin' => $origin,
            'destination' => $destination,
            'startDateTime' => $startDateTime,
            'type' => $type,
        ])->getMock();
        $requestForm->method('getOrigin')->willReturn($origin);
        $requestForm->method('getDestination')->willReturn($destination);
        $requestForm->method('getStartDateTime')->willReturn($startDateTime);
        $requestForm->method('getType')->willReturn($type);

        return $requestForm;
    }
}