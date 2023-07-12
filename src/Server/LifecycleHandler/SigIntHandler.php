<?php

declare(strict_types=1);

namespace K911\Swoole\Server\LifecycleHandler;

use OpenSwoole\Process;
use OpenSwoole\Server;

final class SigIntHandler implements ServerStartHandlerInterface
{
    private int $signalInterrupt;

    public function __construct(private readonly ?ServerStartHandlerInterface $decorated = null)
    {
        $this->signalInterrupt = \defined('SIGINT') ? (int) \constant('SIGINT') : 2;
    }

    public function handle(Server $server): void
    {
        // 2 => SIGINT
        Process::signal($this->signalInterrupt, function () use ($server) {
            $server->stop($server->worker_id);
            $server->shutdown();
        });

        if ($this->decorated instanceof ServerStartHandlerInterface) {
            $this->decorated->handle($server);
        }
    }
}
