<?php
namespace app\models\commission\repositories;

use app\exceptions\RepositoryException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use app\models\commission\Commission;
use app\models\commission\Id;
use Ramsey\Uuid\Uuid;

class CommissionDoctrineRepository implements CommissionRepositoryInterface
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
     * DoctrineCommissionRepository constructor.
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
     * @return Commission|null|object
     */
    public function get(Id $id)
    {
        try {
            $commission = $this->entityRepository->find($id);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }

        return $commission;
    }

    public function getLast()
    {
        try {
            $commissions = $this->entityRepository->findBy([], ['id' => 'DESC'], 1);
            $commission = end($commissions);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }

        return $commission;
    }
    /**
     * @param Commission $commission
     * @return CommissionRepositoryInterface|void
     */
    public function add(Commission $commission)
    {
        try {
            $this->em->persist($commission);
            $this->em->flush($commission);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }
    }

    /**
     * @param Commission $commission
     * @return CommissionRepositoryInterface|void
     */
    public function update(Commission $commission)
    {
        try {
            $this->em->flush($commission);
        } catch (\Exception $exception) {
            throw new RepositoryException();
        }
    }

    /**
     * @param Commission $commission
     * @return CommissionRepositoryInterface|void
     */
    public function delete(Commission $commission)
    {
        try {
            $this->em->remove($commission);
            $this->em->flush($commission);
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
     * @return Commission[]|array
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