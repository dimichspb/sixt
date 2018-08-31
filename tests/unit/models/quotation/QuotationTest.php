<?php
namespace app\tests\unit\models\quotation;

use app\models\commission\Commission;
use app\models\commission\Created;
use app\models\commission\Percent;
use app\models\quotation\Quotation;
use app\models\vehicleClass\Example;
use app\models\vehicleClass\Id;
use app\models\vehicleClass\Name;
use app\models\vehicleClass\Title;
use app\sdk\MyDriver\entities\Currency;
use app\sdk\MyDriver\entities\Price;
use app\sdk\MyDriver\entities\VehicleClass;
use app\sdk\MyDriver\Offer;
use Codeception\Test\Unit;

class QuotationTest extends Unit
{
    /**
     *
     */
    public function testCreateSuccess()
    {
        $offer = $this->getOfferMock(
            $vehicleClass = $this->getSdkVehicleClassMock(VehicleClass::ECONOMY_CLASS),
            $price = $this->getSdkPriceMock(1000),
            $currency = $this->getSdkCurrencyMock(Currency::EUR)
        );
        $commission = $this->getCommissionMock(
            $commissionId = $this->getCommissionIdMock('1'),
            $commissionCreated = $this->getCommissionCreatedMock('2018-08-31 00:00:00'),
            $percent = $this->getPercentMock(100)
        );
        $vehicleClass = $this->getVehicleClassMock(
            $vehicleClassId = $this->getVehicleClassIdMock('1'),
            $name = $this->getNameMock(Name::ECONOMY_CLASS),
            $title = $this->getTitleMock('Economy class'),
            $example = $this->getExampleMock('Economy class car')
        );

        $quotation = new Quotation($offer, $commission, $vehicleClass);

        expect($quotation->getVehicleClass())->equals($vehicleClass);
        expect($quotation->getOffer())->equals($offer);
        expect($quotation->getCommission())->equals($commission);
        expect($quotation->getPrice()->getValue())->equals(20);
        expect($quotation->getCurrency()->getValue())->equals(\app\entities\Currency::EUR);
    }

    /**
     * @param VehicleClass $vehicleClass
     * @param Price $price
     * @param Currency $currency
     * @return Offer
     */
    protected function getOfferMock(VehicleClass $vehicleClass, Price $price, Currency $currency)
    {
        $priceReduced = $this->getMockBuilder(Price::class)->setConstructorArgs([
            'value' => $price->getValue() / 100
        ])->getMock();
        $priceReduced->method('getValue')->willReturn($price->getValue() / 100);

        $offer = $this->getMockBuilder(Offer::class)->setConstructorArgs([
            'vehicleClass' => $vehicleClass,
            'price' => $price,
            'currency' => $currency,
        ])->getMock();

        $offer->method('getPrice')->willReturn($price);
        $offer->method('getPriceReduced')->willReturn($priceReduced);
        $offer->method('getCurrency')->willReturn($currency);
        $offer->method('getVehicleClass')->willReturn($vehicleClass);

        return $offer;
    }

    /**
     * @param \app\models\commission\Id $id
     * @param Created $created
     * @param Percent $percent
     * @return Commission
     */
    protected function getCommissionMock(\app\models\commission\Id $id, Created $created, Percent $percent)
    {
        $commission = $this->getMockBuilder(Commission::class)->setConstructorArgs([
            'id' => $id,
            'created' => $created,
            'percent' => $percent,
        ])->setMethods(['recordEvent', 'getId', 'getCreated', 'getPercent'])->getMock();

        $commission->method('getId')->willReturn($id);
        $commission->method('getCreated')->willReturn($created);
        $commission->method('getPercent')->willReturn($percent);

        return $commission;
    }

    /**
     * @param Id $id
     * @param Name $name
     * @param Title $title
     * @param Example $example
     * @return \app\models\vehicleClass\VehicleClass
     */
    protected function getVehicleClassMock(Id $id, Name $name, Title $title, Example $example)
    {
        $vehicleClass = $this->getMockBuilder(\app\models\vehicleClass\VehicleClass::class)->setConstructorArgs([
            'id' => $id,
            'name' => $name,
            'title' => $title,
            'example' => $example,
        ])->setMethods(['recordEvent', 'getId', 'getName', 'getTitle', 'getExample'])->getMock();

        $vehicleClass->method('getId')->willReturn($id);
        $vehicleClass->method('getName')->willReturn($name);
        $vehicleClass->method('getTitle')->willReturn($title);
        $vehicleClass->method('getExample')->willReturn($example);

        return $vehicleClass;
    }

    /**
     * @param $value
     * @return \app\models\commission\Id
     */
    protected function getCommissionIdMock($value)
    {
        return $this->getEntityMock(\app\models\commission\Id::class, $value);
    }

    /**
     * @param $value
     * @return Created
     */
    protected function getCommissionCreatedMock($value)
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
     * @param $value
     * @return Name
     */
    protected function getNameMock($value)
    {
        return $this->getEntityMock(Name::class, $value);
    }

    /**
     * @param $value
     * @return Id
     */
    protected function getVehicleClassIdMock($value)
    {
        return $this->getEntityMock(Id::class, $value);
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
     * @param $value
     * @return VehicleClass
     */
    protected function getSdkVehicleClassMock($value)
    {
        return $this->getEntityMock(VehicleClass::class, $value);
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
     * @return Currency
     */
    protected function getSdkCurrencyMock($value)
    {
        return $this->getEntityMock(Currency::class, $value);
    }

    protected function getEntityMock($class, $value)
    {
        $mock = $this->getMockBuilder($class)
            ->setConstructorArgs(['value' => $value])
            ->getMock();
        $mock->method('getValue')->willReturn($value);

        return $mock;
    }
}