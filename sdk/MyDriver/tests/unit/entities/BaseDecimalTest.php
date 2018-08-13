<?php
namespace app\sdk\MyDriver\tests\unit\entities;

use app\sdk\MyDriver\entities\BaseDecimal;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class BaseDecimalTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseDecimal::class)
            ->setConstructorArgs(['value' => 10.00])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(10.00);

        $mock = $this
            ->getMockBuilder(BaseDecimal::class)
            ->setConstructorArgs(['value' => 10])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(10);

        $mock = $this
            ->getMockBuilder(BaseDecimal::class)
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
            ->getMockBuilder(BaseDecimal::class)
            ->setConstructorArgs(['value' => 'test'])
            ->getMockForAbstractClass();
    }
}