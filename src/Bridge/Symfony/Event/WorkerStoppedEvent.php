<?php

declare(strict_types=1);

namespace K911\Swoole\Bridge\Symfony\Event;

use OpenSwoole\Server;
use Symfony\Contracts\EventDispatcher\Event;

final class WorkerStoppedEvent extends Event
{
    public const NAME = 'swoole_bundle.worker.stopped';

    public function __construct(
        private Server $server,
        private int $workerId
    ) {
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function getWorkerId(): int
    {
        return $this->workerId;
    }
}
