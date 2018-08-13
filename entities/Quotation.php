<?php
namespace app\entities;

use app\sdk\MyDriver\Offer;

class Quotation
{
    protected $commission;
    protected $offer;

    /**
     * @var Price
     */
    protected $price;

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var VehicleClass
     */
    protected $vehicleClass;

    public function __construct(Offer $offer, Commission $commission)
    {
        $this->offer = $offer;
        $this->commission = $commission;

        $this->updatePrice();
    }

    protected function updatePrice()
    {
        $this->price = new Price($this->addCommission($this->offer->getPrice(), $this->commission));
        $this->currency = new Currency($this->offer->getCurrency()->getValue());
        $this->vehicleClass = new VehicleClass($this->offer->getVehicleClass()->getValue());
    }

    protected function addCommission(\app\sdk\MyDriver\entities\Price $price, Commission $commission)
    {
        return $price->getValue() + ($price->getValue() * $commission->getValue() / 100);
    }

    public function getOffer()
    {
        return $this->offer;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getVehicleClass()
    {
        return $this->vehicleClass;
    }

}