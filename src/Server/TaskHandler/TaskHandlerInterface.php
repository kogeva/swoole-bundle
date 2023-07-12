<?php

declare(strict_types=1);

namespace K911\Swoole\Server\TaskHandler;

use OpenSwoole\Server;

interface TaskHandlerInterface
{
    public function handle(Server $server, Server\Task $task): void;
}
