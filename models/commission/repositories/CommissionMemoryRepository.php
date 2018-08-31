<?php
namespace app\models\commission\repositories;

use app\models\commission\Name;
use app\models\commission\repositories\CommissionRepositoryInterface;
use app\models\commission\Commission;
use app\models\commission\Id;
use app\exceptions\RepositoryException;
use Ramsey\Uuid\Uuid;

class CommissionMemoryRepository implements CommissionRepositoryInterface
{
    /**
     * @var Commission[]
     */
    private $items = [];

    /**
     * @param Id $id
     * @return Commission|null
     */
    public function get(Id $id)
    {
        if (!isset($this->items[$id->getValue()])) {
            return null;
        }
        return clone $this->items[$id->getValue()];
    }

    public function getLast()
    {
        $commissions = $this->items;
        $commission = end($commissions);

        return $commission;
    }

    /**
     * @param Commission $commission
     * @return CommissionRepositoryInterface|void
     */
    public function add(Commission $commission)
    {
        $this->items[$commission->getId()->getValue()] = $commission;
    }

    /**
     * @param Commission $commission
     * @return CommissionRepositoryInterface|void
     */
    public function update(Commission $commission)
    {
        if (!isset($this->items[$commission->getId()->getValue()])) {
            throw new RepositoryException('Not found');
        }
        $this->items[$commission->getId()->getValue()] = $commission;
    }

    /**
     * @param Commission $commission
     * @return CommissionRepositoryInterface|void
     */
    public function delete(Commission $commission)
    {
        if (!isset($this->items[$commission->getId()->getValue()])) {
            throw new RepositoryException('Not found');
        }

        unset($this->items[$commission->getId()->getValue()]);

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
            throw new RepositoryException();
        }

        return $id;
    }

    /**
     * @return Commission[]
     */
    public function all()
    {
        return $this->items;
    }
}