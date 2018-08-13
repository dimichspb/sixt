<?php
namespace app\sdk\MyDriver;

use app\sdk\MyDriver\entities\DateTime;
use app\sdk\MyDriver\entities\PlaceName;
use app\sdk\MyDriver\entities\Type;

class OffersRequest extends Request
{
    protected $origin;
    protected $destination;
    protected $dateTime;
    protected $type;

    public function __construct(PlaceName $origin, PlaceName $destination, DateTime $dateTime, Type $type)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->dateTime = $dateTime;
        $this->type = $type;
    }

    /**
     * @return PlaceName
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @return PlaceName
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }


}