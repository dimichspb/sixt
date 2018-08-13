<?php
namespace app\widgets\GoogleMaps\services;


use app\widgets\GoogleMaps\entities\Draggable;
use app\widgets\GoogleMaps\entities\PlaceName;
use app\widgets\GoogleMaps\entities\StrokeColor;
use app\widgets\GoogleMaps\entities\TravelMode;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\services\GeocodingClient;

class GoogleMapsService
{
    protected $geocodingClient;

    public function __construct(GeocodingClient $geocodingClient)
    {
        $this->geocodingClient = $geocodingClient;

    }

    public function getLocationByAddress(PlaceName $address)
    {
        $response = $this->geocodingClient->lookup([
            'address' => $address->getValue()
        ]);

        if (is_null($response)) {
            throw new \RuntimeException('Geocoding doesn\'t work');
        }

        if (!$response instanceof \stdClass) {
            throw new \RuntimeException('Expectin \stdClass object, but got ' . gettype($response));
        }

        return new LatLng([
            'lat' => $response->geometry->location->lat,
            'lng' => $response->geometry->location->lng,
        ]);
    }

    public function getDirectionService(Map $map, PlaceName $origin, PlaceName $destination, TravelMode $travelMode,
                                        StrokeColor $strokeColor, Draggable $draggable)
    {
        $polylineOptions = new PolylineOptions([
            'strokeColor' => $strokeColor->getValue(),
            'draggable' => $draggable->getValue(),
        ]);

        $directionRequest = new DirectionsRequest([
            'origin' => $origin->getValue(),
            'destination' => $destination->getValue(),
            'travelMode' => $travelMode->getValue(),
        ]);

        $directionRenderer = new DirectionsRenderer([
            'map' => $map->getName(),
            'polylineOptions' => $polylineOptions
        ]);

        // Finally the directions service
        return new DirectionsService([
            'directionsRenderer' => $directionRenderer,
            'directionsRequest' => $directionRequest
        ]);
    }
}