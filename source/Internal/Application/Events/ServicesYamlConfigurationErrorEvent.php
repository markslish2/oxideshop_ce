<?php declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * @internal
 */
class ServicesYamlConfigurationErrorEvent extends ConfigurationErrorEvent
{
    const NAME = self::class;

    /**
     * ServicesYamlConfigurationErrorEvent constructor.
     *
     * @param string $configurationFilePath
     */
    public function __construct($configurationFilePath)
    {
        parent::__construct(
            self::ERROR_LEVEL_ERROR,
            'There are undefined classes in the config.yaml file',
            $configurationFilePath
        );
    }
}
