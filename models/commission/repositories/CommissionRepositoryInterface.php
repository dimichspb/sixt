<?php
namespace app\models\commission\repositories;

use app\models\commission\Commission;
use app\models\commission\Id;
use app\exceptions\RepositoryException;

interface CommissionRepositoryInterface
{
    /**
     * @param Id $id
     * @throws RepositoryException
     * @return Commission
     */
    public function get(Id $id);

    /**
     * @return Commission
     */
    public function getLast();

    /**
     * @param Commission $commission
     * @throws RepositoryException
     * @return $this
     */
    public function add(Commission $commission);

    /**
     * @param Commission $commission
     * @throws RepositoryException
     * @return $this
     */
    public function update(Commission $commission);

    /**
     * @param Commission $commission
     * @throws RepositoryException
     * @return $this
     */
    public function delete(Commission $commission);

    /**
     * @throws RepositoryException
     * @return Id
     */
    public function nextId();

    /**
     * @throws RepositoryException
     * @return Commission[]
     */
    public function all();
}