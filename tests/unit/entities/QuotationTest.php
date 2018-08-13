<?php
namespace app\tests\unit\entities;

use app\entities\Commission;
use app\entities\Quotation;
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
        $offer = $this->getOfferMock();

        $quotation = new Quotation($offer, $this->getCommissionMock());

        expect($quotation->getVehicleClass()->getValue())->equals(\app\entities\VehicleClass::ECONOMY_CLASS);
        expect($quotation->getOffer())->equals($offer);
        expect($quotation->getPrice()->getValue())->equals(200);
        expect($quotation->getCurrency()->getValue())->equals(\app\entities\Currency::EUR);
    }

    /**
     * @return Offer
     */
    protected function getOfferMock()
    {
        $vehicleClass = $this->getMockBuilder(VehicleClass::class)->setConstructorArgs([
            'value' => VehicleClass::ECONOMY_CLASS
        ])->getMock();
        $vehicleClass->method('getValue')->willReturn(VehicleClass::ECONOMY_CLASS);

        $price = $this->getMockBuilder(Price::class)->setConstructorArgs([
            'value' => 100
        ])->getMock();
        $price->method('getValue')->willReturn(100);

        $currency = $this->getMockBuilder(Currency::class)->setConstructorArgs([
            'value' => Currency::EUR
        ])->getMock();
        $currency->method('getValue')->willReturn(Currency::EUR);

        $offer = $this->getMockBuilder(Offer::class)->setConstructorArgs([
            'vehicleClass' => $vehicleClass,
            'price' => $price,
            'currency' => $currency,
        ])->getMock();
        $offer->method('getPrice')->willReturn($price);
        $offer->method('getCurrency')->willReturn($currency);
        $offer->method('getVehicleClass')->willReturn($vehicleClass);

        return $offer;
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
}