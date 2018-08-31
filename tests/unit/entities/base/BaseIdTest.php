<?php
namespace app\tests\unit\entities\base;

use app\entities\base\BaseId;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class BaseIdTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseId::class)
            ->setConstructorArgs(['value' => 'id'])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals('id');
    }

    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(BaseId::class)
            ->setConstructorArgs(['value' => '00112233445566778899'])
            ->getMockForAbstractClass();

        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(BaseId::class)
            ->setConstructorArgs(['value' => true])
            ->getMockForAbstractClass();
    }

    /**
     *
     */
    public function testToStringSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseId::class)
            ->setConstructorArgs(['value' => 'id'])
            ->getMockForAbstractClass();

        expect($mock === 'id');
    }

}