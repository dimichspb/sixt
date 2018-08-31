<?php
namespace app\tests\unit\services\vehicleClass;

use app\events\dispatchers\DummyEventDispatcher;
use app\events\dispatchers\EventDispatcherInterface;
use app\models\vehicleClass\Example;
use app\models\vehicleClass\Name;
use app\models\vehicleClass\repositories\VehicleClassMemoryRepository;
use app\models\vehicleClass\repositories\VehicleClassRepositoryInterface;
use app\models\vehicleClass\Title;
use app\models\vehicleClass\VehicleClass;
use app\services\vehicleClass\VehicleClassService;
use Codeception\Test\Unit;

class VehicleClassServiceTest extends Unit
{
    public function testGetByNameSuccess()
    {
        $eventDispatcher = $this->getEventDispatcherMock();

        $vehicleClassService = new VehicleClassService(
            $vehicleClassRepository = $this->getVehicleClassRepositoryMock(
                $vehicleClassOrigin = $this->getVehicleClassMock(
                    $vehicleId = $this->getVehicleClassIdMock('1'),
                    $name = $this->getNameMock(Name::ECONOMY_CLASS),
                    $title = $this->getTitleMock('Economy class'),
                    $example = $this->getExampleMock('Economy class car')
                )
            ),
            $eventDispatcher
        );

        $sdkVehicleClass = $this->getSdkVehicleClassMock(\app\sdk\MyDriver\entities\VehicleClass::ECONOMY_CLASS);

        $vehicleClass = $vehicleClassService->getByName(new Name($sdkVehicleClass->getValue()));

        expect($vehicleClass)->isInstanceOf(VehicleClass::class);
        expect($vehicleClass->getId()->getValue())->equals($vehicleId->getValue());
        expect($vehicleClass->getName()->getValue())->equals($name->getValue());
        expect($vehicleClass->getTitle()->getValue())->equals($title->getValue());
        expect($vehicleClass->getExample()->getValue())->equals($example->getValue());
    }

    /**
     * @param VehicleClass $vehicleClass
     * @return VehicleClassRepositoryInterface
     */
    protected function getVehicleClassRepositoryMock(VehicleClass $vehicleClass)
    {
        $mock = $this->getMockBuilder(VehicleClassMemoryRepository::class)->getMock();
        $mock->method('getByName')->willReturn($vehicleClass);

        return $mock;
    }

    /**
     * @param \app\models\vehicleClass\Id $id
     * @param Name $name
     * @param Title $title
     * @param Example $example
     * @return VehicleClass
     */
    protected function getVehicleClassMock(\app\models\vehicleClass\Id $id, Name $name, Title $title, Example $example)
    {
        $mock = $this->getMockBuilder(VehicleClass::class)->setConstructorArgs([
            'id' => $id,
            'name' => $name,
            'title' => $title,
            'example' => $example,
        ])->setMethods(['recordEvent', 'getId', 'getName', 'getTitle', 'getExample'])->getMock();

        $mock->method('getId')->willReturn($id);
        $mock->method('getName')->willReturn($name);
        $mock->method('getTitle')->willReturn($title);
        $mock->method('getExample')->willReturn($example);

        return $mock;
    }

    /**
     * @param $value
     * @return \app\models\vehicleClass\Id
     */
    protected function getVehicleClassIdMock($value)
    {
        return $this->getEntityMock(\app\models\vehicleClass\Id::class, $value);
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

    /**
     * @param $value
     * @return \app\sdk\MyDriver\entities\VehicleClass
     */
    protected function getSdkVehicleClassMock($value)
    {
        return $this->getEntityMock(\app\sdk\MyDriver\entities\VehicleClass::class, $value);
    }

    /**
     * @return EventDispatcherInterface
     */
    protected function getEventDispatcherMock()
    {
        $mock = $this->getMockBuilder(DummyEventDispatcher::class)->getMock();

        return $mock;
    }

    protected function getEntityMock($class, $value)
    {
        $mock = $this->getMockBuilder($class)->setConstructorArgs(['value' => $value])->getMock();
        $mock->method('getValue')->willReturn($value);

        return $mock;
    }
}