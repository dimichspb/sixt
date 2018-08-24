<?php
namespace app\tests\unit\entities;

use app\entities\base\BaseString;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class BaseStringTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseString::class)
            ->setConstructorArgs(['value' => 'string'])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals('string');
    }

    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(BaseString::class)
            ->setConstructorArgs(['value' => 10])
            ->getMockForAbstractClass();

        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(BaseString::class)
            ->setConstructorArgs(['value' => true])
            ->getMockForAbstractClass();
    }

    /**
     *
     */
    public function testToStringSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseString::class)
            ->setConstructorArgs(['value' => 'string'])
            ->getMockForAbstractClass();

        expect($mock === 'string');
    }

}