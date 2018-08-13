<?php

namespace app\tests\unit\entities;

use app\entities\BaseBool;
use Assert\Assert;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class BaseBoolTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseBool::class)
            ->setConstructorArgs(['value' => true])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(true);

        $mock = $this
            ->getMockBuilder(BaseBool::class)
            ->setConstructorArgs(['value' => false])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(false);
    }

    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(BaseBool::class)
            ->setConstructorArgs(['value' => 'true'])
            ->getMockForAbstractClass();
    }
}