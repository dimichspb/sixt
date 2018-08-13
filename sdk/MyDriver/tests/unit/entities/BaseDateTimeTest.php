<?php
namespace app\sdk\MyDriver\tests\unit\entities;

use app\sdk\MyDriver\entities\BaseDateTime;
use Codeception\Test\Unit;

class BaseDateTimeTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseDateTime::class)
            ->setConstructorArgs(['value' => '2018-08-14T08:20:18+00:00'])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals('2018-08-14T08:20:18+00:00');

        $mock = $this
            ->getMockBuilder(BaseDateTime::class)
            ->setConstructorArgs(['value' => '2018-08-15T08:20:18+00:00'])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals('2018-08-15T08:20:18+00:00');
    }
}