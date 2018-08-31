<?php
namespace app\models\history;

use app\events\EventTrait;
use app\models\BaseModel;
use app\models\history\events\HistoryCreatedEvent;

class History extends BaseModel
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
     * @var UserId
     */
    protected $userId;

    /**
     * @var Ip
     */
    protected $ip;

    /**
     * @var Agent
     */
    protected $agent;

    /**
     * @var Origin
     */
    protected $origin;

    /**
     * @var Destination
     */
    protected $destination;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var Type
     */
    protected $type;


    public function __construct(Id $id, Created $created, UserId $userId, Ip $ip, Agent $agent, Origin $origin,
                                Destination $destination, DateTime $dateTime, Type $type)
    {
        $this->id = $id;
        $this->created = $created;
        $this->userId = $userId;
        $this->ip = $ip;
        $this->agent = $agent;
        $this->origin = $origin;
        $this->destination = $destination;
        $this->dateTime = $dateTime;
        $this->type = $type;

        $this->recordEvent(new HistoryCreatedEvent($this));
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
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return Ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @return Origin
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @return Destination
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