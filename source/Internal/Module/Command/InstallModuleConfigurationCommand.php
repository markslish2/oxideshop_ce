<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Module\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
class InstallModuleConfigurationCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setDescription('Install module configuration.')
            ->addArgument('module-path', InputArgument::REQUIRED, 'Module path')
            ->setHelp('Command installs module configuration.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $modulePath = $input->getArgument('module-path');
    }
}
