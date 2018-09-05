<?php
namespace app\tests\unit\models\commission\repositories;

use app\models\commission\Commission;
use app\models\commission\Created;
use app\models\commission\Id;
use app\models\commission\Percent;
use app\models\commission\repositories\CommissionDoctrineRepository;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;

class CommissionDoctrineRepositoryTest extends Unit
{
    /**
     * @depends testAdd
     */
    public function testGet()
    {

    }

    /**
     * @depends testAdd
     */
    public function testGetLast()
    {

    }

    /**
     * @skip
     * @depends testNextId
     */
    public function testAdd()
    {
        $repository = $this->getRepository();

        $commission = $this->getCommissionMock(
            $id = $this->getIdMock($repository->nextId()->getValue()),
            $created = $this->getCreatedMock(date('Y-m-d H:i:s', time())),
            $percent = $this->getPercentMock(100)
        );

        $repository->add($commission);

        $found = $repository->get($id);

        expect($found->getId()->getValue())->equals($id->getValue());
        expect($found->getCreated()->getValue())->equals($created->getValue());
        expect($found->getPercent()->getValue())->equals($percent->getValue());
    }

    /**
     * @depends testAdd
     */
    public function testUpdate()
    {

    }

    /**
     * @depends testAdd
     */
    public function testDelete()
    {

    }

    public function testNextId()
    {
        $repository = $this->getRepository();

        $id = $repository->nextId();

        expect(is_string($id->getValue()));
        expect(strlen($id->getValue()))->equals(36);
    }

    /**
     * @depends testAdd
     */
    public function testAll()
    {

    }

    /**
     * @param Id $id
     * @param Created $created
     * @param Percent $percent
     * @return Commission
     */
    protected function getCommissionMock(Id $id, Created $created, Percent $percent)
    {
        $mock = $this->getMockBuilder(Commission::class)->setConstructorArgs([
            'id' => $id,
            'created' => $created,
            'percent' => $percent,
        ])->setMethods(['recordEvent'])->getMock();

        return $mock;
    }


    /**
     * @param $value
     * @return Id
     */
    protected function getIdMock($value)
    {
        return $this->getEntityMock(Id::class, $value);
    }

    /**
     * @param $value
     * @return Created
     */
    protected function getCreatedMock($value)
    {
        return $this->getEntityMock(Created::class, $value);
    }

    /**
     * @param $value
     * @return Percent
     */
    protected function getPercentMock($value)
    {
        return $this->getEntityMock(Percent::class, $value);
    }

    protected function getEntityMock($class, $value)
    {
        $mock = $this->getMockBuilder($class)
            ->setConstructorArgs(['value' => $value])
            ->getMock();
        $mock->method('getValue')->willReturn($value);

        return $mock;
    }

    protected function getRepository()
    {
        /** @var EntityManager $em */
        $em = \Yii::$container->get(EntityManager::class);
        $em->getConfiguration()->setMetadataDriverImpl(new SimplifiedYamlDriver([
            \Yii::getAlias('@app/models/commission/mapping') => 'app\models\commission',
        ]));
        return new CommissionDoctrineRepository($em, $em->getRepository(Commission::class));
    }
}