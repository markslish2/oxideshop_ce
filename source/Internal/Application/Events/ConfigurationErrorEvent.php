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
class ConfigurationErrorEvent extends Event
{
    const ERROR_LEVEL_DEBUG = 0;
    const ERROR_LEVEL_INFO = 1;
    const ERROR_LEVEL_WARN = 2;
    const ERROR_LEVEL_ERROR = 3;

    /**
     * @var int $errorlevel
     */
    private $errorlevel;

    /**
     * @var string $errormessage
     */
    private $errormessage;

    /**
     * @var string $configurationFilePath
     */
    private $configurationFilePath;

    /**
     * @param int    $errorlevel
     * @param int    $errormessage
     * @param string $configurationFilePath
     */
    public function __construct(int $errorlevel, string $errormessage, string $configurationFilePath)
    {
        $this->errorlevel = $errorlevel;
        $this->errormessage = $errormessage;
        $this->configurationFilePath = $configurationFilePath;
    }

    /**
     * Returns the file that is misconfigured
     *
     * @return string
     */
    public function getConfigurationFilePath()
    {
        return $this->configurationFilePath;
    }

    /**
     * @return int
     */
    public function getErrorLevel(): int
    {
        return $this->errorlevel;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errormessage;
    }
}
