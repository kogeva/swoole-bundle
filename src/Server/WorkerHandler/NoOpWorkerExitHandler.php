<?php

declare(strict_types=1);

namespace K911\Swoole\Server\WorkerHandler;

use OpenSwoole\Server;

final class NoOpWorkerExitHandler implements WorkerExitHandlerInterface
{
    public function handle(Server $server, int $workerId): void
    {
        // noop
    }
}
