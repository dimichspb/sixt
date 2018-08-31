<?php
namespace app\services\vehicleClass;

use app\models\vehicleClass\Name;
use app\models\vehicleClass\repositories\VehicleClassRepositoryInterface;
use app\events\dispatchers\EventDispatcherInterface;

class VehicleClassService
{
    /**
     * @var VehicleClassRepositoryInterface
     */
    private $vehicleClassRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(VehicleClassRepositoryInterface $vehicleClassRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->vehicleClassRepository = $vehicleClassRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getByName(Name $name)
    {
        $vehicleClass = $this->vehicleClassRepository->getByName($name);
        $this->eventDispatcher->dispatch($vehicleClass->getEvents());

        return $vehicleClass;
    }
}