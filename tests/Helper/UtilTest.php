<?php


namespace SearchAggregator\Tests\Helper;

use SearchAggregator\Helper\Util;
use SearchAggregator\Tests\BaseTest;

class UtilTest extends BaseTest
{
    public function testGoogleUrlCleaner()
    {
        $tinyUrl = 'http://www.google.com/url?q=https://pointerbrandprotection.com/&sa=U&ved=0ahUKEwjytdDG_LbfAhUBCiwKHRMMAaMQFggXMAA&usg=AOvVaw18BMbkMtSF5l_CZigCddal';
        $realCleanUrl = 'https://pointerbrandprotection.com/';
        $cleanUrl = Util::googleUrlCleaner($tinyUrl);
        $this->assertTrue($realCleanUrl == $cleanUrl);
    }
}
