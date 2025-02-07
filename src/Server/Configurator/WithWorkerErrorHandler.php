<?php

declare(strict_types=1);

namespace K911\Swoole\Server\Configurator;

use K911\Swoole\Server\WorkerHandler\WorkerErrorHandlerInterface;
use OpenSwoole\Http\Server;

final class WithWorkerErrorHandler implements ConfiguratorInterface
{
    private $handler;

    public function __construct(WorkerErrorHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function configure(Server $server): void
    {
        $server->on('WorkerError', [$this->handler, 'handle']);
    }
}
