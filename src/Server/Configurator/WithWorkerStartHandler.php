<?php

declare(strict_types=1);

namespace K911\Swoole\Server\Configurator;

use K911\Swoole\Server\WorkerHandler\WorkerStartHandlerInterface;
use OpenSwoole\Http\Server;

final class WithWorkerStartHandler implements ConfiguratorInterface
{
    public function __construct(private WorkerStartHandlerInterface $handler)
    {
    }

    public function configure(Server $server): void
    {
        $server->on('WorkerStart', [$this->handler, 'handle']);
    }
}
