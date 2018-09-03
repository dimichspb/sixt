<?php
namespace app\services\history;

use app\events\dispatchers\EventDispatcherInterface;
use app\models\history\Agent;
use app\models\history\Created;
use app\models\history\DateTime;
use app\models\history\Destination;
use app\models\history\dto\HistoryCreateDto;
use app\models\history\History;
use app\models\history\Id;
use app\models\history\Ip;
use app\models\history\Origin;
use app\models\history\repositories\HistoryRepositoryInterface;
use app\models\history\Type;
use app\models\history\UserId;
use Assert\Assertion;

class HistoryService
{
    /**
     * @var HistoryRepositoryInterface
     */
    protected $historyRepository;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(HistoryRepositoryInterface $historyRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->historyRepository = $historyRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function save(History $history)
    {
        if ($this->historyRepository->get($history->getId())) {
            return $this->historyRepository->update($history);
        }

        return $this->historyRepository->add($history);
    }
    
    public function all()
    {
        return $this->historyRepository->all();
    }

    public function delete(History $history)
    {
        return $this->historyRepository->delete($history);
    }

    public function createFromArray(array $arguments)
    {
        Assertion::keyExists($arguments, 'userId');
        Assertion::keyExists($arguments, 'ip');
        Assertion::keyExists($arguments, 'agent');
        Assertion::keyExists($arguments, 'origin');
        Assertion::keyExists($arguments, 'destination');
        Assertion::keyExists($arguments, 'dateTime');
        Assertion::keyExists($arguments, 'type');

        $id = isset($arguments['id'])? $arguments['id']: $this->historyRepository->nextId()->getValue();
        $created = isset($arguments['created'])? $arguments['created']: null;

        $dto = new HistoryCreateDto();
        $dto->id = $id;
        $dto->created = $created;
        $dto->userId = $arguments['userId'];
        $dto->ip = $arguments['ip'];
        $dto->agent = $arguments['agent'];
        $dto->origin = $arguments['origin'];
        $dto->destination = $arguments['destination'];
        $dto->dateTime = $arguments['dateTime'];
        $dto->type = $arguments['type'];

        return $this->create($dto);
    }

    public function create(HistoryCreateDto $dto)
    {
        return new History(
            new Id($dto->id),
            new Created($dto->created),
            new UserId($dto->userId),
            new Ip($dto->ip),
            new Agent($dto->agent),
            new Origin($dto->origin),
            new Destination($dto->destination),
            new DateTime($dto->dateTime),
            new Type($dto->type)
        );
    }
}