<?php

namespace app\widgets\GoogleMaps\entities;

use Assert\Assertion;

class TravelMode extends BaseString
{
    public function assert($value)
    {
        Assertion::inArray($value,[
           \dosamigos\google\maps\services\TravelMode::DRIVING,
           \dosamigos\google\maps\services\TravelMode::BICYCLING,
           \dosamigos\google\maps\services\TravelMode::TRANSIT,
           \dosamigos\google\maps\services\TravelMode::WALKING
        ]);
    }
}