<?php

declare(strict_types=1);

namespace K911\Swoole\Server\TaskHandler;

use OpenSwoole\Server;

/**
 * Task Finished Handler is called only when Task Handler returns any result or OpenSwoole\Server->finish() is called.
 *
 * @see https://www.swoole.co.uk/docs/modules/swoole-server/callback-functions#onfinish
 */
interface TaskFinishedHandlerInterface
{
    public function handle(Server $server, int $taskId, $data): void;
}
