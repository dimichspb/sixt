<?php
namespace app\models\history\repositories;

use app\exceptions\RepositoryException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use app\models\history\History;
use app\models\history\Id;
use Ramsey\Uuid\Uuid;

class HistoryDoctrineRepository implements HistoryRepositoryInterface
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
     * DoctrineHistoryRepository constructor.
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
     * @return History|null|object
     */
    public function get(Id $id)
    {
        try {
            $history = $this->entityRepository->find($id);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $history;
    }

    /**
     * @param History $history
     * @return HistoryRepositoryInterface|void
     */
    public function add(History $history)
    {
        try {
            $this->em->persist($history);
            $this->em->flush($history);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param History $history
     * @return HistoryRepositoryInterface|void
     */
    public function update(History $history)
    {
        try {
            $this->em->flush($history);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param History $history
     * @return HistoryRepositoryInterface|void
     */
    public function delete(History $history)
    {
        try {
            $this->em->remove($history);
            $this->em->flush($history);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
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
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $id;
    }

    /**
     * @return History[]|array
     */
    public function all()
    {
        try {
            $results = $this->entityRepository->findAll();
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $results;
    }
}