<?php
namespace app\tests\unit\entities;

use app\entities\DateTime;
use Codeception\Test\Unit;

class DateTimeTest extends Unit
{
    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(\Exception::class);

        $mock = $this
            ->getMockBuilder(DateTime::class)
            ->setConstructorArgs(['value' => '2018-08-32T08:20:18+00:00'])
            ->getMockForAbstractClass();

    }
}