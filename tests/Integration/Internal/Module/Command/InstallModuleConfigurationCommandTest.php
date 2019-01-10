<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Module\Command;

use OxidEsales\EshopCommunity\Internal\Module\Command\InstallModuleConfigurationCommand;
use OxidEsales\EshopCommunity\Internal\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Module\Configuration\Dao\ProjectConfigurationDaoInterface;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * @internal
 */
class InstallModuleConfigurationCommandTest extends ModuleCommandsTestCase
{
    public function testExecute()
    {
        $consoleOutput = $this->execute(
            $this->getApplication(),
            $this->get(InstallModuleConfigurationCommand::class),
            new ArrayInput(['command' => 'oe:module:install-configuration', 'module-path' => __DIR__ . '/Fixtures/testmodule'])
        );

        $this->assertContains('Module configuration installed', $consoleOutput);

        $moduleConfigurationDao = $this->get(ModuleConfigurationDaoInterface::class);
    }
}
