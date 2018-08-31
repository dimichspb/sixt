<?php
namespace app\models\history\repositories;

use app\models\history\History;
use app\models\history\Id;
use app\exceptions\RepositoryException;

interface HistoryRepositoryInterface
{
    /**
     * @param Id $id
     * @throws RepositoryException
     * @return History
     */
    public function get(Id $id);

    /**
     * @param History $history
     * @throws RepositoryException
     * @return boolean
     */
    public function add(History $history);

    /**
     * @param History $history
     * @throws RepositoryException
     * @return boolean
     */
    public function update(History $history);

    /**
     * @param History $history
     * @throws RepositoryException
     * @return boolean
     */
    public function delete(History $history);

    /**
     * @throws RepositoryException
     * @return Id
     */
    public function nextId();

    /**
     * @throws RepositoryException
     * @return History[]
     */
    public function all();
}