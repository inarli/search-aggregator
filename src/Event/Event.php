<?php


namespace SearchAggregator\Event;

/**
 * Class Event
 * @package SearchAggregator\Event
 */
class Event
{
    const BEFORE_REQUEST_EVENT = 'beforeRequest';
    const AFTER_RESPONSE_EVENT = 'afterResponse';
    const SEARCH_RESULT_ITEM_CALLBACK = 'searchResultItemCallback';
    const SEARCH_RESULT_CALLBACK = 'searchResultCallback';

    /**
     * Return event list as an array
     *
     * @return array
     */
    public static function getEventList(): array
    {
        return [
            self::BEFORE_REQUEST_EVENT,
            self::AFTER_RESPONSE_EVENT,
            self::SEARCH_RESULT_ITEM_CALLBACK,
            self::SEARCH_RESULT_CALLBACK
        ];
    }
}
