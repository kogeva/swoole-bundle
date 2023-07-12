<?php

declare(strict_types=1);

namespace K911\Swoole\Server\Runtime\HMR;

use OpenSwoole\Server;

interface HotModuleReloaderInterface
{
    /**
     * Reload HttpServer if changes in files were detected.
     */
    public function tick(Server $server): void;
}
