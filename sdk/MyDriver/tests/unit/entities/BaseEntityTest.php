<?php
namespace app\sdk\MyDriver\tests\unit\entities;

use app\sdk\MyDriver\entities\base\BaseEntity;
use Codeception\Test\Unit;

class BaseEntityTest extends Unit
{
    /**
     *
     */
    public function testGetValueSuccess()
    {
        $mock = $this
            ->getMockBuilder(BaseEntity::class)
            ->setConstructorArgs(['value' => true])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(true);

        $mock = $this
            ->getMockBuilder(BaseEntity::class)
            ->setConstructorArgs(['value' => false])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(false);
    }
}