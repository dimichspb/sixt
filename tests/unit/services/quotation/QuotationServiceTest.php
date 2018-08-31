<?php
namespace app\tests\unit\services;

use app\events\dispatchers\DummyEventDispatcher;
use app\events\dispatchers\EventDispatcherInterface;
use app\models\commission\Commission;
use app\entities\Currency;
use app\entities\DateTime;
use app\entities\PlaceName;
use app\models\commission\Created;
use app\models\commission\Id;
use app\models\commission\Percent;
use app\models\commission\repositories\CommissionMemoryRepository;
use app\models\commission\repositories\CommissionRepositoryInterface;
use app\models\quotation\Quotation;
use app\entities\Type;
use app\models\vehicleClass\Example;
use app\models\vehicleClass\Name;
use app\models\vehicleClass\repositories\VehicleClassMemoryRepository;
use app\models\vehicleClass\repositories\VehicleClassRepositoryInterface;
use app\models\vehicleClass\Title;
use app\models\vehicleClass\VehicleClass;
use app\forms\RequestForm;
use app\sdk\MyDriver\endpoints\Offers;
use app\sdk\MyDriver\entities\ApiKey;
use app\sdk\MyDriver\entities\Price;
use app\sdk\MyDriver\http\HttpClient;
use app\sdk\MyDriver\MyDriver;
use app\sdk\MyDriver\Offer;
use app\sdk\MyDriver\parsers\JsonParser;
use app\services\commission\CommissionService;
use app\services\quotation\QuotationService;
use app\services\vehicleClass\VehicleClassService;
use Codeception\Stub;
use Codeception\Test\Unit;

class QuotationServiceTest extends Unit
{
    /**
     * @throws \Psr\Http\Client\ClientException
     */
    public function testGetQuotationsSuccess()
    {
        $eventDispatcher = $this->getEventDispatcherMock();

        $quotationService = new QuotationService(
            $this->getMyDriverMock(
                $offer = $this->getOfferMock(
                    $sdkVehicleClass = $this->getSdkVehicleClassMock(\app\sdk\MyDriver\entities\VehicleClass::ECONOMY_CLASS),
                    $price = $this->getSdkPriceMock(1000),
                    $currency = $this->getSdkCurrencyMock(\app\sdk\MyDriver\entities\Currency::EUR)

                )
            ),
            $this->getCommissionServiceMock(
                $commissionRepository = $this->getCommissionRepositoryMock(
                    $commission = $this->getCommissionMock(
                        $commissionId = $this->getCommissionIdMock('1'),
                        $created = $this->getCreatedMock('2018-08-31 00:00:00'),
                        $percent = $this->getPercentMock(100)
                    )
                ),
                $eventDispatcher
            ),
            $this->getVehicleClassServiceMock(
                $vehicleClassRepository = $this->getVehicleClassRepositoryMock(
                    $vehicleClass = $this->getVehicleClassMock(
                        $vehicleId = $this->getVehicleClassIdMock('1'),
                        $name = $this->getNameMock(Name::ECONOMY_CLASS),
                        $title = $this->getTitleMock('Economy class'),
                        $example = $this->getExampleMock('Economy class car')
                    )
                ),
                $eventDispatcher
            ),
            $eventDispatcher
        );

        $quotations = $quotationService->getQuotations($this->getRequestFormMock());

        expect(count($quotations))->equals(4);
        expect($quotations)->containsOnlyInstancesOf(Quotation::class);
        foreach ($quotations as $quotation) {
            expect($quotation->getOffer()->getPrice()->getValue())->equals(1000);
            expect($quotation->getCommission())->equals($commission);

            expect($quotation->getCurrency()->getValue())->equals($currency->getValue());
            expect($quotation->getPrice()->getValue())->equals($price->getValue() * 2 / 100);
            expect($quotation->getVehicleClass()->getName()->getValue())->equals($sdkVehicleClass->getValue());
        }
    }

    /**
     * @param Offer $offer
     * @return MyDriver
     */
    protected function getMyDriverMock(Offer $offer)
    {
        $apiKey = $this->getMockBuilder(ApiKey::class)->getMock();
        $httpClient = $this->getMockBuilder(HttpClient::class)->getMock();
        $parser = $this->getMockBuilder(JsonParser::class)->getMock();

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
     * @param \app\sdk\MyDriver\entities\VehicleClass $vehicleClass
     * @param Price $price
     * @param \app\sdk\MyDriver\entities\Currency $currency
     * @return Offer
     */
    protected function getOfferMock(\app\sdk\MyDriver\entities\VehicleClass $vehicleClass, Price $price, \app\sdk\MyDriver\entities\Currency $currency)
    {
        $mock = $this->getMockBuilder(Offer::class)->setConstructorArgs([
            'vehicleClass' => $vehicleClass,
            'price' => $price,
            'currency' => $currency,
        ])->getMock();

        $priceReduced = $this->getEntityMock(Price::class, $price->getValue() / 100);

        $mock->method('getVehicleClass')->willReturn($vehicleClass);
        $mock->method('getPrice')->willReturn($price);
        $mock->method('getPriceReduced')->willReturn($priceReduced);
        $mock->method('getCurrency')->willReturn($currency);

        return $mock;
    }
    /**
     * @param $value
     * @return Price
     */
    protected function getSdkPriceMock($value)
    {
        return $this->getEntityMock(Price::class, $value);
    }

    /**
     * @param $value
     * @return \app\sdk\MyDriver\entities\Currency
     */
    protected function getSdkCurrencyMock($value)
    {
        return $this->getEntityMock(\app\sdk\MyDriver\entities\Currency::class, $value);
    }

    /**
     * @param $value
     * @return \app\sdk\MyDriver\entities\VehicleClass
     */
    protected function getSdkVehicleClassMock($value)
    {
        return $this->getEntityMock(\app\sdk\MyDriver\entities\VehicleClass::class, $value);
    }

    /**
     * @param CommissionRepositoryInterface $commissionRepository
     * @param EventDispatcherInterface $eventDispatcher
     * @return CommissionService
     */
    protected function getCommissionServiceMock(CommissionRepositoryInterface $commissionRepository, EventDispatcherInterface $eventDispatcher)
    {
        $mock = $this->getMockBuilder(CommissionService::class)->setConstructorArgs([
            'commissionRepository' => $commissionRepository,
            'eventDispatcher' => $eventDispatcher,
        ])->getMock();
        $mock->method('getLast')->willReturn($commissionRepository->getLast());

        return $mock;
    }

    /**
     * @param VehicleClassRepositoryInterface $vehicleClassRepository
     * @param EventDispatcherInterface $eventDispatcher
     * @return VehicleClassService
     */
    protected function getVehicleClassServiceMock(VehicleClassRepositoryInterface $vehicleClassRepository, EventDispatcherInterface $eventDispatcher)
    {
        $mock = $this->getMockBuilder(VehicleClassService::class)->setConstructorArgs([
            'vehicleClassRepository' => $vehicleClassRepository,
            'eventDispatcher' => $eventDispatcher,
        ])->getMock();

        $mock->method('getByName')->will($this->returnCallback(function ($arg) use ($vehicleClassRepository) {
            return $vehicleClassRepository->getByName($arg);
        }));

        return $mock;
    }

    /**
     * @param Commission $commission
     * @return CommissionRepositoryInterface
     */
    protected function getCommissionRepositoryMock(Commission $commission)
    {
        $mock = $this->getMockBuilder(CommissionMemoryRepository::class)->getMock();
        $mock->method('getLast')->willReturn($commission);

        return $mock;
    }

    /**
     * @param VehicleClass $vehicleClass
     * @return VehicleClassMemoryRepository
     */
    protected function getVehicleClassRepositoryMock(VehicleClass $vehicleClass)
    {
        $mock = $this->getMockBuilder(VehicleClassMemoryRepository::class)->getMock();
        $mock->method('getByName')->willReturn($vehicleClass);

        return $mock;
    }

    /**
     * @param Id $id
     * @param Created $created
     * @param Percent $percent
     * @return Commission
     */
    public function getCommissionMock(Id $id, Created $created, Percent $percent)
    {
        $mock = $this->getMockBuilder(Commission::class)->setConstructorArgs([
            'id' => $id,
            'created' => $created,
            'percent' => $percent,
        ])->setMethods(['recordEvent', 'getId', 'getCreated', 'getPercent'])->getMock();
        $mock->method('getId')->willReturn($id);
        $mock->method('getCreated')->willReturn($created);
        $mock->method('getPercent')->willReturn($percent);

        return $mock;
    }

    /**
     * @param $value
     * @return Id
     */
    protected function getCommissionIdMock($value)
    {
        return $this->getEntityMock(Id::class, $value);
    }

    /**
     * @param $value
     * @return Created
     */
    protected function getCreatedMock($value)
    {
        return $this->getEntityMock(Created::class, $value);
    }

    /**
     * @param $value
     * @return Percent
     */
    protected function getPercentMock($value)
    {
        return $this->getEntityMock(Percent::class, $value);
    }

    /**
     * @param \app\models\vehicleClass\Id $id
     * @param Name $name
     * @param Title $title
     * @param Example $example
     * @return VehicleClass
     */
    protected function getVehicleClassMock(\app\models\vehicleClass\Id $id, Name $name, Title $title, Example $example)
    {
        $mock = $this->getMockBuilder(VehicleClass::class)->setConstructorArgs([
            'id' => $id,
            'name' => $name,
            'title' => $title,
            'example' => $example,
        ])->setMethods(['recordEvent', 'getId', 'getName', 'getTitle', 'getExample'])->getMock();

        $mock->method('getId')->willReturn($id);
        $mock->method('getName')->willReturn($name);
        $mock->method('getTitle')->willReturn($title);
        $mock->method('getExample')->willReturn($example);

        return $mock;
    }

    /**
     * @param $value
     * @return \app\models\vehicleClass\Id
     */
    protected function getVehicleClassIdMock($value)
    {
        return $this->getEntityMock(\app\models\vehicleClass\Id::class, $value);
    }

    /**
     * @param $value
     * @return Name
     */
    protected function getNameMock($value)
    {
        return $this->getEntityMock(Name::class, $value);
    }

    /**
     * @param $value
     * @return Title
     */
    protected function getTitleMock($value)
    {
        return $this->getEntityMock(Title::class, $value);
    }

    /**
     * @param $value
     * @return Example
     */
    protected function getExampleMock($value)
    {
        return $this->getEntityMock(Example::class, $value);
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
        ])->setMethods(['getOrigin', 'getDestination', 'getStartDateTime', 'getType'])->getMock();

        $requestForm->method('getOrigin')->willReturn($origin);
        $requestForm->method('getDestination')->willReturn($destination);
        $requestForm->method('getStartDateTime')->willReturn($startDateTime);
        $requestForm->method('getType')->willReturn($type);

        return $requestForm;
    }

    /**
     * @return EventDispatcherInterface
     */
    protected function getEventDispatcherMock()
    {
        $mock = $this->getMockBuilder(DummyEventDispatcher::class)->getMock();

        return $mock;
    }

    protected function getEntityMock($class, $value)
    {
        $mock = $this->getMockBuilder($class)->setConstructorArgs(['value' => $value])->getMock();
        $mock->method('getValue')->willReturn($value);

        return $mock;
    }
}