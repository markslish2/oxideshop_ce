<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Module\Setup\Installer;

use OxidEsales\EshopCommunity\Internal\Module\Setup\Installer\ModuleCopyServiceInterface;

/**
 * Class ModuleCopyService
 *
 * @package OxidEsales\EshopCommunity\Internal\Module\Setup\Installer
 */
class ModuleCopyService implements ModuleCopyServiceInterface
{
    /**
     * @param string $packagePath
     */
    public function copyModuleFiles(string $packagePath)
    {

    }

    /**
     * @param string $packagePath
     *
     * @return bool
     */
    public function moduleFilesPresent(string $packagePath): bool
    {
        return false;
    }


}
