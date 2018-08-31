<?php
namespace app\models\vehicleClass\repositories;

use app\models\vehicleClass\Name;
use app\models\vehicleClass\VehicleClass;
use app\models\vehicleClass\Id;
use app\exceptions\RepositoryException;

interface VehicleClassRepositoryInterface
{
    /**
     * @param Id $id
     * @throws RepositoryException
     * @return VehicleClass
     */
    public function get(Id $id);

    /**
     * @param Name $name
     * @return VehicleClass
     */
    public function getByName(Name $name);

    /**
     * @param VehicleClass $vehicleClass
     * @throws RepositoryException
     * @return $this
     */
    public function add(VehicleClass $vehicleClass);

    /**
     * @param VehicleClass $vehicleClass
     * @throws RepositoryException
     * @return $this
     */
    public function update(VehicleClass $vehicleClass);

    /**
     * @param VehicleClass $vehicleClass
     * @throws RepositoryException
     * @return $this
     */
    public function delete(VehicleClass $vehicleClass);

    /**
     * @throws RepositoryException
     * @return Id
     */
    public function nextId();

    /**
     * @throws RepositoryException
     * @return VehicleClass[]
     */
    public function all();
}