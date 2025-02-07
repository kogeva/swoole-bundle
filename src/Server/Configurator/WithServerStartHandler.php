<?php

declare(strict_types=1);

namespace K911\Swoole\Server\Configurator;

use K911\Swoole\Server\HttpServerConfiguration;
use K911\Swoole\Server\LifecycleHandler\ServerStartHandlerInterface;
use OpenSwoole\Http\Server;

final class WithServerStartHandler implements ConfiguratorInterface
{
    public function __construct(
        private ServerStartHandlerInterface $handler,
        private HttpServerConfiguration $configuration
    ) {
    }

    public function configure(Server $server): void
    {
        // see: https://github.com/swoole/swoole-src/blob/077c2dfe84d9f2c6d47a4e105f41423421dd4c43/src/server/reactor_process.cc#L181
        if ($this->configuration->isReactorRunningMode()) {
            return;
        }

        $server->on('start', [$this->handler, 'handle']);
    }
}
