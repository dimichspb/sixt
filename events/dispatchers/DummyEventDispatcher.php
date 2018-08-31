<?php
namespace app\events\dispatchers;

use app\events\EventCollection;

class DummyEventDispatcher implements EventDispatcherInterface
{
    public function dispatch(EventCollection $events)
    {
        foreach ($events as $event) {
            \Yii::info('Dispatch event ' . get_class($event), self::class);
        }
    }
}