<?php
namespace app\services\vehicleClass;

use app\models\vehicleClass\dto\VehicleClassCreateDto;
use app\models\vehicleClass\Example;
use app\models\vehicleClass\Id;
use app\models\vehicleClass\Name;
use app\models\vehicleClass\repositories\VehicleClassRepositoryInterface;
use app\events\dispatchers\EventDispatcherInterface;
use app\models\vehicleClass\Title;
use app\models\vehicleClass\VehicleClass;
use Assert\Assertion;

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

    public function save(VehicleClass $vehicleClass)
    {
        if ($this->vehicleClassRepository->get($vehicleClass->getId())) {
            return $this->vehicleClassRepository->update($vehicleClass);
        }

        return $this->vehicleClassRepository->add($vehicleClass);
    }

    public function all()
    {
        return $this->vehicleClassRepository->all();
    }

    public function delete(VehicleClass $vehicleClass)
    {
        return $this->vehicleClassRepository->delete($vehicleClass);
    }

    public function createFromArray(array $arguments)
    {
        Assertion::keyExists($arguments, 'name');
        Assertion::keyExists($arguments, 'title');
        Assertion::keyExists($arguments, 'example');

        $id = isset($arguments['id'])? $arguments['id']: $this->vehicleClassRepository->nextId()->getValue();

        $dto = new VehicleClassCreateDto();
        $dto->id = $id;
        $dto->name = $arguments['name'];
        $dto->title = $arguments['title'];
        $dto->example = $arguments['example'];

        return $this->create($dto);
    }

    public function create(VehicleClassCreateDto $dto)
    {
        return new VehicleClass(
            new Id($dto->id),
            new Name($dto->name),
            new Title($dto->title),
            new Example($dto->example)
        );
    }
}