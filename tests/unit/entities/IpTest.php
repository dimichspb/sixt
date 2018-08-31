<?php
namespace app\tests\unit\entities;

use app\entities\Ip;
use app\entities\Type;
use Assert\AssertionFailedException;
use Codeception\Test\Unit;

class IpTest extends Unit
{
    /**
     *
     */
    public function testAssertSuccess()
    {
        $ip = new Ip($value = '255.255.255.255');

        expect($ip->getValue())->equals($value);
    }

    /**
     *
     */
    public function testAssertTextFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $ip = new Ip($value = 'THIS.IS.INVALID.IP');
    }

    public function testAssertZerosFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $ip = new Ip($value = '000.000.000.000');
    }

    public function testAssertLettersFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $ip = new Ip($value = 'AAA.BBB.CCC.DDD');
    }

    public function testAssertTooShortFailed()
    {
        $this->expectException(AssertionFailedException::class);

        $ip = new Ip($value = '255.255.255');

    }
}