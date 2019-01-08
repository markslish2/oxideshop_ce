<?php declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Events;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class EventLoggingSubscriber
 *
 * @package OxidEsales\EshopCommunity\Internal\Application\Events
 */
class EventLoggingSubscriber implements EventSubscriberInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EventLoggingSubscriber constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ConfigurationErrorEvent $event
     */
    public function logConfigurationError(ConfigurationErrorEvent $event)
    {
        $logLevelMap = [$event::ERROR_LEVEL_ERROR => LogLevel::ERROR,
            $event::ERROR_LEVEL_WARN => LogLevel::WARNING,
            $event::ERROR_LEVEL_INFO => LogLevel::INFO,
            $event::ERROR_LEVEL_DEBUG => LogLevel::DEBUG];

        $this->logger->log(
            $logLevelMap[$event->getErrorLevel()],
            $event->getErrorMessage() . ' (' . $event->getConfigurationFilePath() . ')'
        );
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigurationErrorEvent::class => 'logConfigurationError'
        ];
    }
}
