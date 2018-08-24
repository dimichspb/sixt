<?php
namespace app\tests\unit\entities;

use app\entities\VehicleClass\VehicleClass;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class VehicleClassTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(VehicleClass::class)
            ->setConstructorArgs(['value' => VehicleClass::ECONOMY_CLASS])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(VehicleClass::ECONOMY_CLASS);

        $mock = $this
            ->getMockBuilder(VehicleClass::class)
            ->setConstructorArgs(['value' => VehicleClass::FIRST_CLASS])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(VehicleClass::FIRST_CLASS);

        $mock = $this
            ->getMockBuilder(VehicleClass::class)
            ->setConstructorArgs(['value' => VehicleClass::BUSINESS_CLASS])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(VehicleClass::BUSINESS_CLASS);

        $mock = $this
            ->getMockBuilder(VehicleClass::class)
            ->setConstructorArgs(['value' => VehicleClass::BUSINESS_VAN])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(VehicleClass::BUSINESS_VAN);
    }

    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(VehicleClass::class)
            ->setConstructorArgs(['value' => 'UNKNOWN VehicleClass'])
            ->getMockForAbstractClass();
    }
}