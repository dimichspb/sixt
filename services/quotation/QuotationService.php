<?php
namespace app\services\quotation;

use app\entities\Commission;
use app\entities\Quotation;
use app\forms\RequestForm;
use app\sdk\MyDriver\MyDriver;
use app\sdk\MyDriver\OffersRequest;

class QuotationService
{
    /**
     * @var MyDriver
     */
    protected $myDriver;

    /**
     * @var Commission
     */
    protected $commission;

    /**
     * QuotationService constructor.
     * @param MyDriver $myDriver
     * @param Commission $commission
     */
    public function __construct(MyDriver $myDriver, Commission $commission)
    {
        $this->myDriver = $myDriver;
        $this->commission = $commission;
    }

    /**
     * @param RequestForm $requestForm
     * @return Quotation[]
     * @throws \Psr\Http\Client\ClientException
     */
    public function getQuotations(RequestForm $requestForm)
    {
        $quotations = [];

        $offers = $this->myDriver->offers()->run(new OffersRequest(
            new \app\sdk\MyDriver\entities\PlaceName($requestForm->getOrigin()->getValue()),
            new \app\sdk\MyDriver\entities\PlaceName($requestForm->getDestination()->getValue()),
            new \app\sdk\MyDriver\entities\DateTime($requestForm->getStartDateTime()->getValue()),
            new \app\sdk\MyDriver\entities\Type($requestForm->getType()->getValue())
        ));

        foreach ($offers as $offer) {
            $quotations[] = new Quotation($offer, $this->commission);
        }

        return $quotations;
    }
}