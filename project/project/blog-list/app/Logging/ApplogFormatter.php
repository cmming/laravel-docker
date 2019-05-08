<?php

namespace App\Logging;

use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\UidProcessor;

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/5/7
 * Time: 18:28
 */
class ApplogFormatter
{

    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(new UidProcessor);
            //将当前内存使用量添加到日志记录中
            $handler->pushProcessor(new MemoryUsageProcessor);
            //将峰值内存使用量添加到日志记录中
            $handler->pushProcessor(new MemoryPeakUsageProcessor);
            $handler->setFormatter(new JsonFormatter());
        }
    }
}