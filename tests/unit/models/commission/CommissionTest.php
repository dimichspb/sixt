<?php
namespace app\tests\unit\models\commission;

use app\models\commission\Commission;
use app\models\commission\Created;
use app\models\commission\Id;
use app\models\commission\Percent;
use Codeception\Test\Unit;

class CommissionTest extends Unit
{
    public function testCreateSuccess()
    {
        $commission = new Commission(
            $id = $this->getIdMock('1'),
            $created = $this->getCreatedMock('2018-08-31 00:00:00'),
            $percent = $this->getPercentMock(100)
        );

        expect($commission->getId())->equals($id);
        expect($commission->getCreated())->equals($created);
        expect($commission->getPercent())->equals($percent);
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
}