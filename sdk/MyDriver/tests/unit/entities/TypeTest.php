<?php
namespace app\sdk\MyDriver\tests\unit\entities;

use app\sdk\MyDriver\entities\Type;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class TypeTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(Type::class)
            ->setConstructorArgs(['value' => Type::DISTANCE])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(Type::DISTANCE);

        $mock = $this
            ->getMockBuilder(Type::class)
            ->setConstructorArgs(['value' => Type::DURATION])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(Type::DURATION);
    }

    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(Type::class)
            ->setConstructorArgs(['value' => 'UNKNOWN TYPE'])
            ->getMockForAbstractClass();
    }
}