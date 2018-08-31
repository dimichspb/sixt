<?php
namespace app\models\commission;

use app\events\EventTrait;
use app\models\BaseModel;
use app\models\commission\events\CommissionCreatedEvent;

class Commission extends BaseModel
{
    use EventTrait;

    /**
     * @var Id
     */
    protected $id;

    /**
     * @var Created
     */
    protected $created;

    /**
     * @var Percent
     */
    protected $percent;

    public function __construct(Id $id, Created $created, Percent $percent)
    {
        $this->id = $id;
        $this->created = $created;
        $this->percent = $percent;

        $this->recordEvent(new CommissionCreatedEvent($this));
    }

    /**
     * @return Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Created
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return Percent
     */
    public function getPercent()
    {
        return $this->percent;
    }
}