<?php
namespace app\forms;

use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Type;
use app\forms\validators\StringValidator;
use yii\base\Model;

class RequestForm extends Model
{
    /**
     * @var PlaceName
     */
    protected $origin;

    /**
     * @var PlaceName
     */
    protected $destination;

    /**
     * @var DateTime
     */
    protected $startDateTime;

    /**
     * @var Type
     */
    protected $type;

    /**
     * RequestForm constructor.
     * @param PlaceName $origin
     * @param PlaceName $destination
     * @param DateTime $startDateTime
     * @param Type $type
     */
    public function __construct(PlaceName $origin, PlaceName $destination, DateTime $startDateTime, Type $type)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->startDateTime = $startDateTime;
        $this->type = $type;

        parent::__construct();
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        return [
            [['origin', 'destination', 'startDateTime', 'type',], 'required'],
            [['origin', 'destination'], StringValidator::class],
        ];
    }

    /**
     * @return PlaceName
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param $origin
     */
    public function setOrigin($origin)
    {
        $this->origin = new PlaceName($origin);
    }

    /**
     * @return PlaceName
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param $destination
     */
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

    /**
     * @param $startDateTime
     */
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

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = new Type($type);
    }
}