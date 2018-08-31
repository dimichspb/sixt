<?php
namespace app\services\history;

use app\events\dispatchers\EventDispatcherInterface;
use app\models\history\History;
use app\models\history\repositories\HistoryRepositoryInterface;

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

    /**
     * @param History $history
     * @return bool
     */
    public function add(History $history)
    {
        return $this->historyRepository->add($history);
    }
}