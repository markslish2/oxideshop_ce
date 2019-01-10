<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Module\Command;

use OxidEsales\EshopCommunity\Internal\Module\Command\InstallModuleConfigurationCommand;
use OxidEsales\EshopCommunity\Tests\Integration\Internal\TestContainerFactory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class InstallModuleConfigurationCommandTest extends TestCase
{
    public function testCommandIsRegistered()
    {
        $container = (new TestContainerFactory())->create();
        $this->assertInstanceOf(
            InstallModuleConfigurationCommand::class,
            $container->get(InstallModuleConfigurationCommand::class)
        );

        $definition = $container->getDefinition(InstallModuleConfigurationCommand::class);

        $this->assertTrue(
            $definition->hasTag('console.command')
        );
    }
}
