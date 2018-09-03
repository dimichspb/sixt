<?php
namespace app\services\commission;

use app\components\HashIdGenerator;
use app\events\dispatchers\EventDispatcherInterface;
use app\models\commission\Commission;
use app\models\commission\Created;
use app\models\commission\dto\CommissionCreateDto;
use app\models\commission\Id;
use app\models\commission\Percent;
use app\models\commission\repositories\CommissionRepositoryInterface;
use Assert\Assertion;

class CommissionService
{
    /**
     * @var CommissionRepositoryInterface
     */
    protected $commissionRepository;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(CommissionRepositoryInterface $commissionRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->commissionRepository = $commissionRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return \app\models\commission\Commission
     */
    public function getLast()
    {
        return $this->commissionRepository->getLast();
    }

    public function save(Commission $commission)
    {
        if ($this->commissionRepository->get($commission->getId())) {
            return $this->commissionRepository->update($commission);
        }

        return $this->commissionRepository->add($commission);
    }

    public function all()
    {
        return $this->commissionRepository->all();
    }

    public function delete(Commission $commission)
    {
        return $this->commissionRepository->delete($commission);
    }

    public function createFromArray(array $arguments)
    {
        Assertion::keyExists($arguments, 'percent');

        $id = isset($arguments['id'])? $arguments['id']: $this->commissionRepository->nextId()->getValue();
        $created = isset($arguments['created'])? $arguments['created']: null;

        $dto = new CommissionCreateDto();
        $dto->id = $id;
        $dto->created = $created;
        $dto->percent = $arguments['percent'];

        return $this->create($dto);
    }

    public function create(CommissionCreateDto $dto)
    {
        return new Commission(
            new Id($dto->id),
            new Created($dto->created),
            new Percent($dto->percent)
        );
    }
}