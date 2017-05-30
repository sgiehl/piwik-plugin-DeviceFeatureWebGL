<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * Based on code from AdvancedCampaignReporting plugin by Piwik PRO released under GPL v3 or later: https://github.com/PiwikPRO/plugin-AdvancedCampaignReporting
 */
namespace Piwik\Plugins\DevicePluginWebGL\tests\System;

use Piwik\Plugins\DevicePluginWebGL\tests\Fixtures\ManyVisitsWithWebGL;
use Piwik\Tests\Framework\TestCase\SystemTestCase;

/**
 * @group DevicePluginWebGL
 * @group Plugins
 */
class ApiTest extends SystemTestCase
{
    /**
     * @var ManyVisitsWithWebGL
     */
    public static $fixture = null; // initialized below class definition

    public static function getOutputPrefix()
    {
        return '';
    }

    public static function getPathToTestDirectory()
    {
        return dirname(__FILE__);
    }

    /**
     * @dataProvider getApiForTesting
     * @group        TrackSeveralCampaignsTest
     */
    public function testApi($api, $params)
    {
        $this->runApiTests($api, $params);
    }

    public function getApiForTesting()
    {
        $dateTime              = self::$fixture->dateTime;

        $api         = array(
            'DevicePlugins'
        );
        $apiToTest[] = array(
            $api,
            array(
                'idSite'                 => self::$fixture->idSite,
                'date'                   => $dateTime,
                'periods'                => array('day'),
            )
        );

        return $apiToTest;
    }
}

ApiTest::$fixture = new ManyVisitsWithWebGL();
