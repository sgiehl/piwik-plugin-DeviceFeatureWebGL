<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\DeviceFeatureWebGL\tests\Fixtures;

use Piwik\Date;
use Piwik\Tests\Framework\Fixture;

class ManyVisitsWithWebGL extends Fixture
{
    public $idSite   = 1;
    public $dateTime = '2010-01-03 06:22:33';

    public function setUp(): void
    {
        $this->setUpWebsitesAndGoals();
        $this->trackVisits(9);
        $this->trackOtherVisits();
    }

    private function setUpWebsitesAndGoals()
    {
        if (!self::siteCreated($idSite = 1)) {
            self::createWebsite($this->dateTime, 0, "Site 1");
        }
    }

    private function trackVisits($visitorCount)
    {
        static $calledCounter = 0;
        $calledCounter++;

        $dateTime = $this->dateTime;
        $idSite   = $this->idSite;

        $t = self::getTracker($idSite, $dateTime);
        $t->setTokenAuth(self::getTokenAuth());
        for ($i = 0; $i != $visitorCount; ++$i) {
            $t->setVisitorId( substr(md5($i + $calledCounter * 1000), 0, $t::LENGTH_VISITOR_ID));
            $t->setIp("1.2.4.$i");

            // first visit
            $date = Date::factory($dateTime)->addHour($i);
            $t->setForceVisitDateTime($date->getDatetime());
            $t->setUrl("http://piwik.net/grue/lair");
            $t->setCustomTrackingParameter('webgl', $i%2);

            $r = $t->doTrackPageView('Any site tracked');
            self::checkResponse($r);

            // second visit
            $date = $date->addHour(1);
            $t->setForceVisitDateTime($date->getDatetime());
            $t->setCustomTrackingParameter('webgl', $i%3);
            $t->setUrl("http://piwik.net/space/quest/iv");

            // Manually record some data
            $t->setDebugStringAppend(
                '&_idts=' . $date->subDay(100)->getTimestampUTC() . // first visit timestamp
                '&_ects=' . $date->subDay(50)->getTimestampUTC() . // Timestamp ecommerce
                '&_viewts=' . $date->subDay(10)->getTimestampUTC() . // Last visit timestamp
                '&_idvc=5' // Visit count
            );
            $r = $t->doTrackPageView("Space Quest XII");

            self::checkResponse($r);
        }
    }

    private function trackOtherVisits()
    {
        $dateTime = $this->dateTime;
        $idSite   = $this->idSite;

        $t = self::getTracker($idSite, $dateTime, $defaultInit = true);
        $t->setVisitorId('fed33392d3a48ab2');
        $t->setTokenAuth(self::getTokenAuth());
        $t->setForceVisitDateTime(Date::factory($dateTime)->addDay(20)->getDatetime());
        $t->setIp('194.57.91.215');
        $t->setUserId('userid.email@example.org');
        $t->setCountry('us');
        $t->setRegion('CA');
        $t->setCity('not a city');
        $t->setPlugins();
        $t->setLatitude(1);
        $t->setLongitude(2);
        $t->setCustomTrackingParameter('webgl', '1');
        $t->setUrl("http://piwik.net/grue/lair");
        $t->setUrlReferrer('http://google.com/?q=Wikileaks FTW');
        $t->setUserAgent("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.2.6) AppleWebKit/522+ (KHTML, like Gecko) Safari/419.3 (.NET CLR 3.5.30729)");
        self::checkResponse($t->doTrackPageView('It\'s pitch black...'));
    }
}
