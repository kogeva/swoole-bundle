<?php

declare(strict_types=1);

namespace K911\Swoole\Server\Configurator;

use K911\Swoole\Server\LifecycleHandler\ServerShutdownHandlerInterface;
use OpenSwoole\Http\Server;

final class WithServerShutdownHandler implements ConfiguratorInterface
{
    public function __construct(private ServerShutdownHandlerInterface $handler)
    {
    }

    public function configure(Server $server): void
    {
        $server->on('shutdown', [$this->handler, 'handle']);
    }
}
