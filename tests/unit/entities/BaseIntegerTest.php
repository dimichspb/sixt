<?php
namespace app\tests\unit\entities;

use app\entities\BaseInteger;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class BaseIntegerTest extends Unit
{
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseInteger::class)
            ->setConstructorArgs(['value' => 10])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(10);

        $mock = $this
            ->getMockBuilder(BaseInteger::class)
            ->setConstructorArgs(['value' => -10])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(-10);
    }

    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(BaseInteger::class)
            ->setConstructorArgs(['value' => 10.10])
            ->getMockForAbstractClass();

        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(BaseInteger::class)
            ->setConstructorArgs(['value' => 'true'])
            ->getMockForAbstractClass();
    }
}