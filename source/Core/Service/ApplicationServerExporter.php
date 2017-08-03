<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version   OXID eShop CE
 */

namespace OxidEsales\EshopCommunity\Core\Service;

/**
 * Prepare application servers information for export.
 *
 * @internal Do not make a module extension for this class.
 * @see      http://oxidforge.org/en/core-oxid-eshop-classes-must-not-be-extended.html
 */
class ApplicationServerExporter implements \OxidEsales\Eshop\Core\Service\ApplicationServerExporterInterface
{
    /**
     * The service class of application server.
     *
     * @var \OxidEsales\Eshop\Core\Service\ApplicationServerServiceInterface
     */
    private $appServerService;

    /**
     * ApplicationServerExporter constructor.
     *
     * @param \OxidEsales\Eshop\Core\Service\ApplicationServerServiceInterface $appServerService
     */
    public function __construct(\OxidEsales\Eshop\Core\Service\ApplicationServerServiceInterface $appServerService)
    {
        $this->appServerService = $appServerService;
    }

    /**
     * Return an array of active application servers.
     *
     * @return array
     */
    public function exportAppServerList()
    {
        $activeServerCollection = [];

        $activeServers = $this->appServerService->loadActiveAppServerList();
        if (is_array($activeServers) && !empty($activeServers)) {
            foreach ($activeServers as $server) {
                $activeServerCollection[] = $this->convertToArray($server);
            }
        }

        return $activeServerCollection;
    }

    /**
     * Converts ApplicationServer object into array for export.
     *
     * @param \OxidEsales\Eshop\Core\DataObject\ApplicationServer $server
     *
     * @return array
     */
    private function convertToArray($server)
    {
        $activeServer = [
            'id' => $server->getId(),
            'ip' => $server->getIp(),
            'lastFrontendUsage' => $server->getLastFrontendUsage(),
            'lastAdminUsage' => $server->getLastAdminUsage()
        ];
        return $activeServer;
    }
}
