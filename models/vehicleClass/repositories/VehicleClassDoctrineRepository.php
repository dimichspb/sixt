<?php
namespace app\models\vehicleClass\repositories;

use app\exceptions\RepositoryException;
use app\models\vehicleClass\Name;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use app\models\vehicleClass\VehicleClass;
use app\models\vehicleClass\Id;
use Ramsey\Uuid\Uuid;

class VehicleClassDoctrineRepository implements VehicleClassRepositoryInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    /**
     * DoctrineVehicleClassRepository constructor.
     * @param EntityManager $em
     * @param EntityRepository $entityRepository
     */
    public function __construct(EntityManager $em, EntityRepository $entityRepository)
    {
        $this->em = $em;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param Id $id
     * @return VehicleClass|null|object
     */
    public function get(Id $id)
    {
        try {
            $vehicleClass = $this->entityRepository->find($id);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }

        return $vehicleClass;
    }

    public function getByName(Name $name)
    {
        try {
            $vehicleClass = $this->entityRepository->findOneBy(['name' => $name->getValue()]);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }

        return $vehicleClass;
    }
    /**
     * @param VehicleClass $vehicleClass
     * @return VehicleClassRepositoryInterface|void
     */
    public function add(VehicleClass $vehicleClass)
    {
        try {
            $this->em->persist($vehicleClass);
            $this->em->flush($vehicleClass);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }
    }

    /**
     * @param VehicleClass $vehicleClass
     * @return VehicleClassRepositoryInterface|void
     */
    public function update(VehicleClass $vehicleClass)
    {
        try {
            $this->em->flush($vehicleClass);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }
    }

    /**
     * @param VehicleClass $vehicleClass
     * @return VehicleClassRepositoryInterface|void
     */
    public function delete(VehicleClass $vehicleClass)
    {
        try {
            $this->em->remove($vehicleClass);
            $this->em->flush($vehicleClass);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }
    }

    /**
     * @return Id
     */
    public function nextId()
    {
        try {
            $id = new Id(Uuid::uuid4()->toString());
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }

        return $id;
    }

    /**
     * @return VehicleClass[]|array
     */
    public function all()
    {
        try {
            $results = $this->entityRepository->findAll();
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }

        return $results;
    }
}