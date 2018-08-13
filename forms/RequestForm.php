<?php
namespace app\forms;

use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Type;
use app\forms\validators\StringValidator;
use yii\base\Model;

class RequestForm extends Model
{
    protected $origin;
    protected $destination;
    protected $startDateTime;
    protected $type;

    public function __construct(PlaceName $origin, PlaceName $destination, DateTime $startDateTime, Type $type)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->startDateTime = $startDateTime;
        $this->type = $type;

        parent::__construct();
    }

    public function rules()
    {
        return [
            [['origin', 'destination', 'startDateTime', 'type',], 'required'],
            [['origin', 'destination'], StringValidator::class],
        ];
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    public function setOrigin($origin)
    {
        $this->origin = new PlaceName($origin);
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function setDestination($destination)
    {
        $this->destination = new PlaceName($destination);
    }

    /**
     * @return DateTime
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    public function setStartDateTime($startDateTime)
    {
        $this->startDateTime = new DateTime($startDateTime);
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = new Type($type);
    }
}