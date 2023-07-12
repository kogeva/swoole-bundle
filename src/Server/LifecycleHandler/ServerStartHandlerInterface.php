<?php

declare(strict_types=1);

namespace K911\Swoole\Server\LifecycleHandler;

use OpenSwoole\Server;

interface ServerStartHandlerInterface
{
    /**
     * Handle "OnStart" event.
     */
    public function handle(Server $server): void;
}
