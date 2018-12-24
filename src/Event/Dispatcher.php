<?php


namespace SearchAggregator\Event;

use SearchAggregator\Event\Listener\ProviderListenerInterface;
use SearchAggregator\Provider\Provider;

/**
 * Class Dispatcher
 * @package SearchAggregator\Event
 */
class Dispatcher
{
    /**
     * Event dispatcher.
     *
     * @param Provider $provider
     * @param $eventType
     * @param $obj
     * @return mixed
     */
    public static function dispatchEvent(Provider $provider, $eventType, $obj)
    {
        if (in_array($eventType, Event::getEventList()) &&
            $provider->getListener() instanceof ProviderListenerInterface) {
            return call_user_func([$provider->getListener(), $eventType], $obj);
        }
        return $obj;
    }
}
