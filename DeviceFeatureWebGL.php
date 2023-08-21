<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
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
        return [
            'API.DevicePlugins.getPlugin.end' => 'setWebGLTitle',
        ];
    }

    /**
     * @param $dataTable
     */
    public function setWebGLTitle($dataTable)
    {
        $dataTables = [];
        if ($dataTable instanceof DataTable\Map) {
            $dataTables = $dataTable->getDataTables();
        } else {
            if ($dataTable instanceof DataTable) {
                $dataTables = [$dataTable];
            }
        }

        foreach ($dataTables as $table) {
            $table->queueFilter(function ($dataTable) {
                $row = $dataTable->getRowFromLabel('Webgl');
                if ($row) {
                    $row->setColumn('label', 'WebGL');
                }
            });
        }
    }

    public function isTrackerPlugin()
    {
        return true;
    }
}
