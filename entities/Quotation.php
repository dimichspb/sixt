<?php
namespace app\entities;

use app\sdk\MyDriver\Offer;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\Model;

class Quotation implements Arrayable
{
    protected $commission;
    protected $offer;

    use ArrayableTrait;
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

    public function fields()
    {
        return [
            'vehicleClass' => function (Quotation $quotation) {
                return $quotation->vehicleClass->getValue();
            },
            'offerPrice' => function (Quotation $quotation) {
                return $quotation->getOffer()->getPrice()->getValue();
            },
            'price' => function (Quotation $quotation) {
                return $quotation->getPrice()->getValue();
            },
            'currency' => function (Quotation $quotation) {
                return $quotation->getCurrency()->getValue();
            }
        ];
    }
}