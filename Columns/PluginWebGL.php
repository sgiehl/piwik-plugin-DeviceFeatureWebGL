<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\DeviceFeatureWebGL\Columns;

use Piwik\Common;
use Piwik\Plugins\DevicePlugins\Columns\DevicePluginColumn;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;
use Piwik\Tracker\Action;

class PluginWebGL extends DevicePluginColumn
{
    protected $columnName = 'config_webgl';
    protected $columnType = 'TINYINT(1) NULL';
    public $columnIcon = 'plugins/DeviceFeatureWebGL/images/webgl.png';

    /**
     * @param Request $request
     * @param Visitor $visitor
     * @param Action|null $action
     * @return mixed
     */
    public function onNewVisit(Request $request, Visitor $visitor, $action)
    {
        return Common::getRequestVar('webgl', 0, 'int', $request->getParams());
    }
}