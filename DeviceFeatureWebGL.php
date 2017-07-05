<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\DeviceFeatureWebGL;

use Piwik\DataTable;
use Piwik\Plugin;

/**
 *
 */
class DeviceFeatureWebGL extends Plugin
{
    /**
     * @see Plugin::registerEvents
     */
    public function registerEvents()
    {
        return array(
            'API.DevicePlugins.getPlugin.end' => 'setWebGLTitle',
        );
    }

    /**
     * @param $dataTable
     */
    public function setWebGLTitle($dataTable)
    {
        $dataTables = array();
        if ($dataTable instanceof DataTable\Map) {
            $dataTables = $dataTable->getDataTables();
        }
         else if ($dataTable instanceof DataTable) {
            $dataTables = array($dataTable);
        }

        foreach ($dataTables as $table) {
            $table->queueFilter(function($dataTable){
                $row = $dataTable->getRowFromLabel('Webgl');
                if ($row) {
                    $row->setColumn('label', 'WebGL');
                }
            });
        }
    }
}
