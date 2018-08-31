<?php
namespace app\tests\unit\entities\vehicleClass;

use app\models\vehicleClass\Name;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class NameTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $name = new Name(Name::ECONOMY_CLASS);

        expect($name->getValue())->equals(Name::ECONOMY_CLASS);

        $name = new Name(Name::FIRST_CLASS);

        expect($name->getValue())->equals(Name::FIRST_CLASS);

        $name = new Name(Name::BUSINESS_CLASS);

        expect($name->getValue())->equals(Name::BUSINESS_CLASS);

        $name = new Name(Name::BUSINESS_VAN);

        expect($name->getValue())->equals(Name::BUSINESS_VAN);
    }

    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $name = new Name('UNKNOWN VehicleClass');
    }
}