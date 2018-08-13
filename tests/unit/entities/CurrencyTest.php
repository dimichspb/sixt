<?php
namespace app\tests\unit\entities;

use app\entities\Currency;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class CurrencyTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $mock = $this
            ->getMockBuilder(Currency::class)
            ->setConstructorArgs(['value' => Currency::EUR])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(Currency::EUR);

        $mock = $this
            ->getMockBuilder(Currency::class)
            ->setConstructorArgs(['value' => Currency::USD])
            ->getMockForAbstractClass();

        expect($mock->getValue())->equals(Currency::USD);
    }

    /**
     *
     */
    public function testAssertFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $mock = $this
            ->getMockBuilder(Currency::class)
            ->setConstructorArgs(['value' => 'CHF'])
            ->getMockForAbstractClass();
    }
}