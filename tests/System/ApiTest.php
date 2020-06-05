<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * Based on code from AdvancedCampaignReporting plugin by Piwik PRO released under GPL v3 or later: https://github.com/PiwikPRO/plugin-AdvancedCampaignReporting
 */
namespace Piwik\Plugins\DeviceFeatureWebGL\tests\System;

use Piwik\Plugins\DeviceFeatureWebGL\tests\Fixtures\ManyVisitsWithWebGL;
use Piwik\Tests\Framework\TestCase\SystemTestCase;

/**
 * @group DeviceFeatureWebGL
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
        $dateTime    = self::$fixture->dateTime;

        $api         = [
            'DevicePlugins'
        ];
        $apiToTest[] = [
            $api,
            [
                'idSite'                 => self::$fixture->idSite,
                'date'                   => $dateTime,
                'periods'                => ['day'],
            ]
        ];

        return $apiToTest;
    }
}

ApiTest::$fixture = new ManyVisitsWithWebGL();
