<?php

declare(strict_types=1);

namespace K911\Swoole\Server\Configurator;

use K911\Swoole\Server\WorkerHandler\WorkerExitHandlerInterface;
use OpenSwoole\Http\Server;

final class WithWorkerExitHandler implements ConfiguratorInterface
{
    private $handler;

    public function __construct(WorkerExitHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function configure(Server $server): void
    {
        $server->on('WorkerExit', [$this->handler, 'handle']);
    }
}
