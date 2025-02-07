<?php

declare(strict_types=1);

namespace K911\Swoole\Tests\Unit\Server\Runtime\HMR;

use K911\Swoole\Server\Runtime\HMR\HotModuleReloaderInterface;
use OpenSwoole\Server;

class HMRSpy implements HotModuleReloaderInterface
{
    public $tick = false;

    public function tick(Server $server): void
    {
        $this->tick = true;
    }
}
