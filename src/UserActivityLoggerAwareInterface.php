<?php


namespace Tervis\EventLoggerBundle;


use Psr\Log\LoggerInterface;

/**
 * Describes a logger-aware instance.
 *
 * Interface UserActivityLoggerAwareInterface
 * @package App\Utils\Log
 */
interface UserActivityLoggerAwareInterface
{
    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $userActivityLogger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $userActivityLogger);
}
