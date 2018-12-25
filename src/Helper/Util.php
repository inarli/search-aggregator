<?php


namespace SearchAggregator\Helper;

/**
 * Class Util
 * @package SearchAggregator\Helper
 */
class Util
{
    /**
     * Google url cleaner function.
     *
     * @param string $url
     * @return string
     */
    public static function googleUrlCleaner(string $url): string
    {
        $parserUrl = parse_url($url);
        if (array_key_exists('query', $parserUrl)) {
            parse_str($parserUrl['query'], $data);
            if (array_key_exists('q', $data)) {
                return  $data['q'];
            }
        }
        return $url;
    }

    /**
     * If url size > 75 it shorten url.
     *
     * @param $url
     * @return string
     */
    public static function urlShortener($url)
    {
        return strlen($url) > 75 ? substr($url, 0, 75) . '...' : $url;
    }
}
