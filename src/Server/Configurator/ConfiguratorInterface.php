<?php

declare(strict_types=1);

namespace K911\Swoole\Server\Configurator;

use OpenSwoole\Http\Server;

interface ConfiguratorInterface
{
    public function configure(Server $server): void;
}
