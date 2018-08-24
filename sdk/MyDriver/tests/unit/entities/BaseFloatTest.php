<?php
namespace app\sdk\MyDriver\tests\unit\entities;

use app\sdk\MyDriver\entities\base\BaseFloat;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class BaseFloatTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseFloat::class)
            ->setConstructorArgs(['value' => 10.10])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(10.10);

        $mock = $this
            ->getMockBuilder(BaseFloat::class)
            ->setConstructorArgs(['value' => 10.00])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(10.00);

        $mock = $this
            ->getMockBuilder(BaseFloat::class)
            ->setConstructorArgs(['value' => 10])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(10);

        $mock = $this
            ->getMockBuilder(BaseFloat::class)
            ->setConstructorArgs(['value' => -10])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(-10);
    }

    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(BaseFloat::class)
            ->setConstructorArgs(['value' => 'true'])
            ->getMockForAbstractClass();
    }
}