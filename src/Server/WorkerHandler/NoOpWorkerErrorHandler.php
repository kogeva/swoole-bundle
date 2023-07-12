<?php

declare(strict_types=1);

namespace K911\Swoole\Server\WorkerHandler;

use OpenSwoole\Server;

final class NoOpWorkerErrorHandler implements WorkerErrorHandlerInterface
{
    public function handle(Server $worker, int $workerId): void
    {
        // noop
    }
}
