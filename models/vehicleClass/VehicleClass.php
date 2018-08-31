<?php
namespace app\models\vehicleClass;

use app\events\EventTrait;
use app\models\BaseModel;
use app\models\vehicleClass\events\VehicleClassCreatedEvent;

class VehicleClass extends BaseModel
{
    use EventTrait;

    /**
     * @var Id
     */
    protected $id;

    /**
     * @var Name
     */
    protected $name;

    /**
     * @var Title
     */
    protected $title;

    /**
     * @var Example
     */
    protected $example;

    public function __construct(Id $id, Name $name, Title $title, Example $example)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->example = $example;

        $this->recordEvent(new VehicleClassCreatedEvent($this));
    }

    /**
     * @return Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Example
     */
    public function getExample()
    {
        return $this->example;
    }
}