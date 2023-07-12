<?php

declare(strict_types=1);

namespace K911\Swoole\Server\LifecycleHandler;

use OpenSwoole\Server;

interface ServerManagerStopHandlerInterface
{
    /**
     * Handle "OnManagerStop" event.
     *
     * Info: Handler is executed in manager process
     */
    public function handle(Server $server): void;
}
