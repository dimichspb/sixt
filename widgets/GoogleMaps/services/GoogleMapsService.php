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
            throw new \RuntimeException('Expecting \stdClass object, but got ' . gettype($response));
        }

        if (isset($response->error_message)) {
            throw new \RuntimeException('Error in service: ' . $response->error_message);
        }

        if (!isset($response->status) || $response->status !== 'OK') {
            throw new \RuntimeException('Service has returned wrong status. Response dump: ' . PHP_EOL . json_encode($response));
        }

        if (!isset($response->results) || !is_array($response->results)) {
            throw new \RuntimeException('Service has returned no results array. Response dump: ' . PHP_EOL . json_encode($response));
        }

        if (!isset($response->results[0])) {
            throw new \RuntimeException('Service has returned no first result. Response dump: ' . PHP_EOL . json_encode($response));
        }

        $result = $response->results[0];

        return new LatLng([
            'lat' => $result->geometry->location->lat,
            'lng' => $result->geometry->location->lng,
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