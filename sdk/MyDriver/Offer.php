<?php
namespace app\sdk\MyDriver;

use app\sdk\MyDriver\entities\Currency;
use app\sdk\MyDriver\entities\Price;
use app\sdk\MyDriver\entities\VehicleClass;

class Offer extends Response
{
    protected $vehicleClass;
    protected $price;
    protected $currency;

    public function __construct(VehicleClass $vehicleClass, Price $price, Currency $currency)
    {
        $this->vehicleClass = $vehicleClass;
        $this->price = $price;
        $this->currency = $currency;
    }

    /**
     * @return VehicleClass
     */
    public function getVehicleClass()
    {
        return $this->vehicleClass;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}