<?php
namespace app\tests\unit\models\history;

use app\models\history\Agent;
use app\models\history\DateTime;
use app\models\history\Destination;
use app\models\history\History;
use app\models\history\Created;
use app\models\history\Id;
use app\models\history\Ip;
use app\models\history\Origin;
use app\models\history\Type;
use app\models\history\UserId;
use Codeception\Test\Unit;

class HistoryTest extends Unit
{
    public function testCreateSuccess()
    {
        $history = new History(
            $id = $this->getIdMock('1'),
            $created = $this->getCreatedMock('2018-08-31 00:00:00'),
            $userId = $this->getUserIdMock('1'),
            $ip = $this->getIpMock('255.255.255.255'),
            $agent = $this->getAgentMock('Chrome'),
            $origin = $this->getOriginMock('Origin place name'),
            $destination = $this->getDestinationMock('Destination place name'),
            $dateTime = $this->getDateTimeMock('2018-08-31 00:00:00'),
            $type = $this->getTypeMock(Type::DISTANCE)
        );

        expect($history->getId())->equals($id);
        expect($history->getCreated())->equals($created);
        expect($history->getUserId())->equals($userId);
        expect($history->getIp())->equals($ip);
        expect($history->getAgent())->equals($agent);
        expect($history->getOrigin())->equals($origin);
        expect($history->getDestination())->equals($destination);
        expect($history->getDateTime())->equals($dateTime);
        expect($history->getType())->equals($type);
    }

    /**
     * @param $value
     * @return Id
     */
    protected function getIdMock($value)
    {
        return $this->getEntityMock(Id::class, $value);
    }

    /**
     * @param $value
     * @return Created
     */
    protected function getCreatedMock($value)
    {
        return $this->getEntityMock(Created::class, $value);
    }

    /**
     * @param $value
     * @return UserId
     */
    protected function getUserIdMock($value)
    {
        return $this->getEntityMock(UserId::class, $value);
    }

    /**
     * @param $value
     * @return Ip
     */
    protected function getIpMock($value)
    {
        return $this->getEntityMock(Ip::class, $value);
    }

    /**
     * @param $value
     * @return Agent
     */
    protected function getAgentMock($value)
    {
        return $this->getEntityMock(Agent::class, $value);
    }

    /**
     * @param $value
     * @return Origin
     */
    protected function getOriginMock($value)
    {
        return $this->getEntityMock(Origin::class, $value);
    }

    /**
     * @param $value
     * @return Destination
     */
    protected function getDestinationMock($value)
    {
        return $this->getEntityMock(Destination::class, $value);
    }

    /**
     * @param $value
     * @return DateTime
     */
    protected function getDateTimeMock($value)
    {
        return $this->getEntityMock(DateTime::class, $value);
    }

    /**
     * @param $value
     * @return Type
     */
    protected function getTypeMock($value)
    {
        return $this->getEntityMock(Type::class, $value);
    }

    protected function getEntityMock($class, $value)
    {
        $mock = $this->getMockBuilder($class)
            ->setConstructorArgs(['value' => $value])
            ->getMock();
        $mock->method('getValue')->willReturn($value);

        return $mock;
    }
}