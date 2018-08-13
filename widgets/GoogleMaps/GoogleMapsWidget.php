<?php
namespace app\widgets\GoogleMaps;

use app\widgets\GoogleMaps\entities\Draggable;
use app\widgets\GoogleMaps\entities\PlaceName;
use app\widgets\GoogleMaps\entities\StrokeColor;
use app\widgets\GoogleMaps\services\GoogleMapsService;
use Assert\Assertion;
use dosamigos\google\maps\services\GeocodingClient;
use yii\base\Application;
use yii\bootstrap\Widget;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use app\widgets\GoogleMaps\entities\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;
use yii\i18n\I18N;

class GoogleMapsWidget extends Widget
{
    public $apiKey;

    public $origin;
    public $originTitle = 'Origin';
    public $destination;
    public $destinationTitle = 'Destination';

    public $zoom = 14;
    public $travelMode = \dosamigos\google\maps\services\TravelMode::DRIVING;
    public $strokeColor = '#FF0000';
    public $draggable = false;

    protected $translator;
    protected $application;

    protected $content;

    /**
     * @var Map
     */
    protected $map;

    protected $googleMapsService;

    public function __construct(GoogleMapsService $googleMapsService, array $config = [])
    {
        $this->googleMapsService = $googleMapsService;

        Assertion::keyIsset($config,'origin');
        Assertion::keyIsset($config, 'destination');

        parent::__construct($config);
    }

    public function init()
    {
        GoogleMapsWidgetAsset::register($this->getView());
        try {
            $origin = $this->googleMapsService->getLocationByAddress(new PlaceName($this->origin));
            $destination = $this->googleMapsService->getLocationByAddress(new PlaceName($this->destination));

            $center = LatLng::getCenterOfCoordinates([
                $origin,
                $destination
            ]);

            $this->map = new Map([
                'center' => $center,
                'width' => '100%',
                'zoom' => $this->zoom,
            ]);

            $script = $this->googleMapsService->getDirectionService(
                $this->map,
                new PlaceName($this->origin),
                new PlaceName($this->destination),
                new TravelMode($this->travelMode),
                new StrokeColor($this->strokeColor),
                new Draggable($this->draggable)
            )->getJs();

            // Thats it, append the resulting script to the map
            $this->map->appendScript($script);

            // Lets add a marker now
            $originMarker = new Marker([
                'position' => $origin,
                'title' => $this->originTitle,
            ]);

            $destinationMarker = new Marker([
                'position' => $destination,
                'title' => $this->destinationTitle,
            ]);

            // Add marker to the map
            $this->map->addOverlay($originMarker);
            $this->map->addOverlay($destinationMarker);

            $this->content = $this->map->display();
        } catch (\Exception $exception) {
            $this->content = $this->render('exception', ['exception' => $exception]);
        }

    }

    public function run()
    {
        echo $this->content;
    }
}