<?php

declare(strict_types=1);

namespace K911\Swoole\Server\TaskHandler;

use OpenSwoole\Server;

final class NoOpTaskFinishedHandler implements TaskFinishedHandlerInterface
{
    public function handle(Server $server, int $taskId, $data): void
    {
        // noop
    }
}
