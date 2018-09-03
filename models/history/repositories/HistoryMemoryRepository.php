<?php
namespace app\models\history\repositories;

use app\models\history\repositories\HistoryRepositoryInterface;
use app\models\history\History;
use app\models\history\Id;
use app\exceptions\RepositoryException;
use Ramsey\Uuid\Uuid;

class HistoryMemoryRepository implements HistoryRepositoryInterface
{
    /**
     * @var History[]
     */
    private $items = [];

    /**
     * @param Id $id
     * @return History|null
     */
    public function get(Id $id)
    {
        if (!isset($this->items[$id->getValue()])) {
            return null;
        }
        return clone $this->items[$id->getValue()];
    }

    /**
     * @param History $history
     * @return HistoryRepositoryInterface|void
     */
    public function add(History $history)
    {
        $this->items[$history->getId()->getValue()] = $history;
    }

    /**
     * @param History $history
     * @return boolean
     */
    public function update(History $history)
    {
        if (!isset($this->items[$history->getId()->getValue()])) {
            throw new RepositoryException('Not found');
        }
        $this->items[$history->getId()->getValue()] = $history;

        return true;
    }

    /**
     * @param History $history
     * @return boolean
     */
    public function delete(History $history)
    {
        if (!isset($this->items[$history->getId()->getValue()])) {
            throw new RepositoryException('Not found');
        }

        unset($this->items[$history->getId()->getValue()]);

        return true;
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
     * @return History[]
     */
    public function all()
    {
        return $this->items;
    }
}