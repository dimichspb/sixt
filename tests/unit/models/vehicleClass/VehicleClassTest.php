<?php
namespace app\tests\unit\entities\vehicleClass;

use app\models\vehicleClass\Example;
use app\models\vehicleClass\Id;
use app\models\vehicleClass\Name;
use app\models\vehicleClass\Title;
use app\models\vehicleClass\VehicleClass;
use Codeception\Test\Unit;

class VehicleClassTest extends Unit
{
    public function testCreateSuccess()
    {
        $vehicleClass = new VehicleClass(
            $this->getIdMock($id = '1'),
            $this->getNameMock($name = Name::ECONOMY_CLASS),
            $this->getTitleMock($title = 'Economy class'),
            $this->getExampleMock($example = 'Economy class car')
        );

        expect($vehicleClass->getId()->getValue())->equals($id);
        expect($vehicleClass->getName()->getValue())->equals($name);
        expect($vehicleClass->getTitle()->getValue())->equals($title);
        expect($vehicleClass->getExample()->getValue())->equals($example);
    }

    /**
     * @param $value
     * @return Name
     */
    protected function getNameMock($value)
    {
        return $this->getEntityMock(Name::class, $value);
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
     * @return Title
     */
    protected function getTitleMock($value)
    {
        return $this->getEntityMock(Title::class, $value);
    }

    /**
     * @param $value
     * @return Example
     */
    protected function getExampleMock($value)
    {
        return $this->getEntityMock(Example::class, $value);
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