<?php
namespace app\models\quotation;

use app\models\commission\Commission;
use app\entities\Currency;
use app\entities\Price;
use app\events\EventTrait;
use app\sdk\MyDriver\Offer;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use app\models\VehicleClass\VehicleClass;

class Quotation implements Arrayable
{
    use ArrayableTrait, EventTrait;

    /**
     * @var Commission
     */
    protected $commission;

    /**
     * @var Offer
     */
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

    /**
     * Quotation constructor.
     * @param Offer $offer
     * @param Commission $commission
     * @param VehicleClass $vehicleClass
     */
    public function __construct(Offer $offer, Commission $commission, VehicleClass $vehicleClass)
    {
        $this->offer = $offer;
        $this->commission = $commission;
        $this->vehicleClass = $vehicleClass;
        $this->currency = new Currency($this->offer->getCurrency()->getValue());
        $this->price = new Price($this->addCommission($this->offer->getPriceReduced(), $this->commission));
    }

    /**
     * @param \app\sdk\MyDriver\entities\Price $price
     * @param Commission $commission
     * @return float|int|null
     */
    protected function addCommission(\app\sdk\MyDriver\entities\Price $price, Commission $commission)
    {
        return $price->getValue() + ($price->getValue() * $commission->getPercent()->getValue() / 100);
    }

    /**
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @return Commission
     */
    public function getCommission()
    {
        return $this->commission;
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
                return $quotation->vehicleClass;
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