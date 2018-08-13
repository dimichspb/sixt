<?php
namespace app\sdk\MyDriver\tests\unit;

use app\sdk\MyDriver\entities\DateTime;
use app\sdk\MyDriver\entities\PlaceName;
use app\sdk\MyDriver\entities\Type;
use app\sdk\MyDriver\OffersRequest;
use Codeception\Test\Unit;

class OffersRequestTest extends Unit
{
    public function testCreateSuccess()
    {
        $origin = $this->getOriginMock();
        $destination = $this->getDestinationMock();
        $dateTime = $this->getDateTimeMock();
        $type = $this->getTypeMock();

        $offersRequest = new OffersRequest($origin, $destination, $dateTime, $type);

        expect($offersRequest->getOrigin())->equals($origin);
        expect($offersRequest->getDestination())->equals($destination);
        expect($offersRequest->getDateTime())->equals($dateTime);
        expect($offersRequest->getType())->equals($type);
    }

    /**
     * @return PlaceName
     */
    protected function getOriginMock()
    {
        $origin = $this->getMockBuilder(PlaceName::class)->setConstructorArgs([
            'value' => 'Origin',
        ])->getMock();
        $origin->method('getValue')->willReturn('Origin');

        return $origin;
    }

    /**
     * @return PlaceName
     */
    protected function getDestinationMock()
    {
        $destination = $this->getMockBuilder(PlaceName::class)->setConstructorArgs([
            'value' => 'Destination',
        ])->getMock();
        $destination->method('getValue')->willReturn('Destination');

        return $destination;
    }

    /**
     * @return DateTime
     */
    protected function getDateTimeMock()
    {
        $dateTime = $this->getMockBuilder(DateTime::class)->setConstructorArgs([
            'value' => '2018-08-14T08:20:24+00:00',
        ])->getMock();
        $dateTime->method('getValue')->willReturn('2018-08-14T08:20:24+00:00');

        return $dateTime;
    }

    /**
     * @return Type
     */
    protected function getTypeMock()
    {
        $type = $this->getMockBuilder(Type::class)->setConstructorArgs([
            'value' => Type::DISTANCE,
        ])->getMock();
        $type->method('getValue')->willReturn(Type::DISTANCE);

        return $type;
    }
}