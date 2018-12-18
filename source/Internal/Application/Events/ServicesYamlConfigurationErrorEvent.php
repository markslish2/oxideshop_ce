<?php
declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * @internal
 */
class ServicesYamlConfigurationErrorEvent extends Event
{
    const NAME = self::class;

    /**
     * @var string $servicesYamlFilePath
     */
    private $servicesYamlFilePath;

    /**
     * ServicesYamlConfigurationErrorEvent constructor.
     *
     * @param string $servicesYamlFilePath
     */
    public function __construct(string $servicesYamlFilePath)
    {
        $this->servicesYamlFilePath = $servicesYamlFilePath;
    }

    /**
     * Returns the file that is misconfigured
     *
     * @return string
     */
    public function getServicesYamlFilePath()
    {
        return $this->servicesYamlFilePath;
    }
}
