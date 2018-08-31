<?php
namespace app\events;

use app\entities\DateTime;
use app\models\BaseModel;

abstract class Event
{
    protected $model;
    protected $datetime;

    public function __construct(BaseModel $model, DateTime $datetime = null)
    {
        $this->model = $model;
        $this->datetime = is_null($datetime)? new DateTime(): $datetime;
    }
}