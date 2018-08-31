<?php
namespace app\events\dispatchers;

use app\events\EventCollection;

interface EventDispatcherInterface
{
    public function dispatch(EventCollection $events);
}