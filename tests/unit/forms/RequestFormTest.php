<?php
namespace app\tests\unit\forms;

use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Type;
use app\forms\RequestForm;
use Codeception\Test\Unit;

class RequestFormTest extends Unit
{
    /**
     *
     */
    public function testCreateSuccess()
    {
        $requestForm = new RequestForm(
            $origin = new PlaceName('Origin'),
            $destination = new PlaceName('Destination'),
            $startDateTime = new DateTime('2018-08-14T08:20:24+00:00'),
            $type = new Type(Type::DISTANCE)
        );

        expect($requestForm->getOrigin())->equals($origin);
        expect($requestForm->getDestination())->equals($destination);
        expect($requestForm->getStartDateTime())->equals($startDateTime);
        expect($requestForm->getType())->equals($type);
    }
}