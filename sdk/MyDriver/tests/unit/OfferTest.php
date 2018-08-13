<?php
namespace app\sdk\MyDriver\tests\unit;

use app\sdk\MyDriver\entities\Currency;
use app\sdk\MyDriver\entities\Price;
use app\sdk\MyDriver\entities\VehicleClass;
use app\sdk\MyDriver\Offer;
use Codeception\Test\Unit;

class OfferTest extends Unit
{
    public function testCreateSuccess()
    {
        $vehicleClass = $this->getVehicleClassMock();
        $price = $this->getPriceMock();
        $currency = $this->getCurrencyMock();

        $offer = new Offer($vehicleClass, $price, $currency);

        expect($offer->getVehicleClass())->equals($vehicleClass);
        expect($offer->getPrice())->equals($price);
        expect($offer->getCurrency())->equals($currency);
        
    }

    /**
     * @return VehicleClass
     */
    protected function getVehicleClassMock()
    {
        $vehicleClass = $this->getMockBuilder(VehicleClass::class)->setConstructorArgs([
            'value' => VehicleClass::ECONOMY_CLASS,
        ])->getMock();
        $vehicleClass->method('getValue')->willReturn(VehicleClass::ECONOMY_CLASS);

        return $vehicleClass;
    }

    /**
     * @return Price
     */
    protected function getPriceMock()
    {
        $price = $this->getMockBuilder(Price::class)->setConstructorArgs([
            'value' => 100,
        ])->getMock();
        $price->method('getValue')->willReturn(100);

        return $price;
    }

    /**
     * @return Currency
     */
    protected function getCurrencyMock()
    {

        $currency = $this->getMockBuilder(Currency::class)->setConstructorArgs([
            'value' => Currency::EUR,
        ])->getMock();
        $currency->method('getValue')->willReturn(Currency::EUR);

        return $currency;
    }
}