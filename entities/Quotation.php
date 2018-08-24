<?php
namespace app\entities;

use app\sdk\MyDriver\Offer;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\Model;
use app\entities\VehicleClass\VehicleClass;

class Quotation implements Arrayable
{
    /**
     * @var Commission
     */
    protected $commission;

    /**
     * @var Offer
     */
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

    /**
     * Quotation constructor.
     * @param Offer $offer
     * @param Commission $commission
     */
    public function __construct(Offer $offer, Commission $commission)
    {
        $this->offer = $offer;
        $this->commission = $commission;

        $this->updatePrice();
    }

    /**
     * Updates prices based on offer and commission
     */
    protected function updatePrice()
    {
        $this->price = new Price($this->addCommission($this->offer->getPriceReduced(), $this->commission));
        $this->currency = new Currency($this->offer->getCurrency()->getValue());
        $this->vehicleClass = new VehicleClass($this->offer->getVehicleClass()->getValue());
    }

    /**
     * @param \app\sdk\MyDriver\entities\Price $price
     * @param Commission $commission
     * @return float|int|null
     */
    protected function addCommission(\app\sdk\MyDriver\entities\Price $price, Commission $commission)
    {
        return $price->getValue() + ($price->getValue() * $commission->getValue() / 100);
    }

    /**
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
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

    /**
     * @return VehicleClass
     */
    public function getVehicleClass()
    {
        return $this->vehicleClass;
    }

    /**
     * Fields for REST API response
     * @return array
     */
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