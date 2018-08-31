<?php
namespace app\services\commission;

use app\events\dispatchers\EventDispatcherInterface;
use app\models\commission\repositories\CommissionRepositoryInterface;

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
}