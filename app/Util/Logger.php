<?php
namespace App\Util;

use Monolog\Logger as BaseLogger;
use Monolog\Handler\StreamHandler;

class Logger extends BaseLogger
{
    protected $microsecondTimestamps = true;

    /**
     * Adds a log record.
     *
     * @param  int     $level   The logging level
     * @param  string  $message The log message
     * @param  array   $context The log context
     * @return Boolean Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = array())
    {
        if (!$this->handlers) {
            $this->pushHandler(new StreamHandler('php://stderr', static::DEBUG));
        }

        $levelName = static::getLevelName($level);

        // check if any handler will handle this message so we can return early and save cycles
        $handlerKey = null;
        reset($this->handlers);
        while ($handler = current($this->handlers)) {
            if ($handler->isHandling(array('level' => $level))) {
                $handlerKey = key($this->handlers);
                break;
            }

            next($this->handlers);
        }

        if (null === $handlerKey) {
            return false;
        }

        if (!static::$timezone) {
            static::$timezone = new \DateTimeZone(date_default_timezone_get() ?: 'UTC');
        }

        if ($this->microsecondTimestamps) {
            $ts = \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)), static::$timezone);
        } else {
            $ts = new \DateTime(null, static::$timezone);
        }
        $ts->setTimezone(static::$timezone);
        if(defined('SERVICE_ENTRY_TYPE') && SERVICE_ENTRY_TYPE=='artisan') {
            $isArtisan = true;
        } else {
            $isArtisan = false;
        }
        if(defined('TRACE_ID_REQUEST_ID')) {
            $requestId = TRACE_ID_REQUEST_ID;
        } else {
            $requestId = microtime(true);
        }
        $record = array(
            'message' => '"' . (string) $message . '"',
            'context' => $context,
            'level' => $level,
            'level_name' => $levelName,
            'channel' => $this->name,
            'datetime' => $ts,
            'millisecond'=>$ts->format('u'),//毫秒
            'request_id' => $requestId,
            'extra' => []
        );

        foreach ($this->processors as $processor) {
            $record = call_user_func($processor, $record);
        }

        while ($handler = current($this->handlers)) {
            if (true === $handler->handle($record)) {
                break;
            }

            next($this->handlers);
        }

        return true;
    }
}
