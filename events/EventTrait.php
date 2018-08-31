<?php
namespace app\events;

trait EventTrait
{
    /**
     * @var EventCollection
     */
    private $events;

    protected function recordEvent(Event $event)
    {
        $this->getEvents()->add($event);
    }

    public function releaseEvents()
    {
        $events = $this->getEvents();
        $this->initEvents();
        return $events;
    }

    /**
     * @return EventCollection
     */
    public function getEvents()
    {
        return is_null($this->events)? $this->initEvents(): $this->events;
    }

    /**
     * @param EventCollection $eventCollection
     * @return EventCollection
     */
    protected function setEvents(EventCollection $eventCollection)
    {
        return $this->events = $eventCollection;
    }

    /**
     * @return EventCollection
     */
    protected function initEvents()
    {
        return $this->events = new EventCollection();
    }
}