<?php
namespace app\models\vehicleClass\repositories;

use app\models\vehicleClass\Name;
use app\models\vehicleClass\repositories\VehicleClassRepositoryInterface;
use app\models\vehicleClass\VehicleClass;
use app\models\vehicleClass\Id;
use app\exceptions\RepositoryException;
use Ramsey\Uuid\Uuid;

class VehicleClassMemoryRepository implements VehicleClassRepositoryInterface
{
    /**
     * @var VehicleClass[]
     */
    private $items = [];

    /**
     * @param Id $id
     * @return VehicleClass|null
     */
    public function get(Id $id)
    {
        if (!isset($this->items[$id->getValue()])) {
            return null;
        }
        $vehicleClass = clone $this->items[$id->getValue()];

        return $vehicleClass;
    }

    public function getByName(Name $name)
    {
        foreach ($this->items as $item) {
            if ($item->getName()->getValue() === $name->getValue()) {
                $vehicleClass = clone $item;
                return $vehicleClass;
            }
        }
        return null;
    }

    /**
     * @param VehicleClass $vehicleClass
     * @return VehicleClassRepositoryInterface|void
     */
    public function add(VehicleClass $vehicleClass)
    {
        $this->items[$vehicleClass->getId()->getValue()] = $vehicleClass;
    }

    /**
     * @param VehicleClass $vehicleClass
     * @return VehicleClassRepositoryInterface|void
     */
    public function update(VehicleClass $vehicleClass)
    {
        if (!isset($this->items[$vehicleClass->getId()->getValue()])) {
            throw new RepositoryException('Not found');
        }
        $this->items[$vehicleClass->getId()->getValue()] = $vehicleClass;
    }

    /**
     * @param VehicleClass $vehicleClass
     * @return VehicleClassRepositoryInterface|void
     */
    public function delete(VehicleClass $vehicleClass)
    {
        if (!isset($this->items[$vehicleClass->getId()->getValue()])) {
            throw new RepositoryException('Not found');
        }

        unset($this->items[$vehicleClass->getId()->getValue()]);

    }

    /**
     * @return Id
     * @throws \Exception
     */
    public function nextId()
    {
        try {
            $id = new Id(Uuid::uuid4()->toString());
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $id;
    }

    /**
     * @return VehicleClass[]
     */
    public function all()
    {
        return $this->items;
    }
}