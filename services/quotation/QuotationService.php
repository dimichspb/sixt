<?php
namespace app\services\quotation;

use app\models\commission\Commission;
use app\events\dispatchers\EventDispatcherInterface;
use app\models\quotation\Quotation;
use app\forms\RequestForm;
use app\models\vehicleClass\Name;
use app\sdk\MyDriver\entities\VehicleClass;
use app\sdk\MyDriver\MyDriver;
use app\sdk\MyDriver\OffersRequest;
use app\services\commission\CommissionService;
use app\services\vehicleClass\VehicleClassService;

class QuotationService
{
    /**
     * @var MyDriver
     */
    protected $myDriver;

    /**
     * @var CommissionService
     */
    protected $commissionService;

    /**
     * @var VehicleClassService
     */
    protected $vehicleClassService;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * QuotationService constructor.
     * @param MyDriver $myDriver
     * @param CommissionService $commissionService
     * @param VehicleClassService $vehicleClassService
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(MyDriver $myDriver, CommissionService $commissionService, VehicleClassService $vehicleClassService,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->myDriver = $myDriver;
        $this->commissionService = $commissionService;
        $this->vehicleClassService = $vehicleClassService;
        $this->eventDispatcher = $eventDispatcher;
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

        $commission = $this->commissionService->getLast();

        foreach ($offers as $offer) {
            $vehicleClass = $this->vehicleClassService->getByName(new Name($offer->getVehicleClass()->getValue()));
            $quotations[] = new Quotation($offer, $commission, $vehicleClass);
        }

        return $quotations;
    }
}