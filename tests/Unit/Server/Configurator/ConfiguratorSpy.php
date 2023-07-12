<?php

declare(strict_types=1);

namespace K911\Swoole\Tests\Unit\Server\Configurator;

use K911\Swoole\Server\Configurator\ConfiguratorInterface;
use OpenSwoole\Http\Server;

final class ConfiguratorSpy implements ConfiguratorInterface
{
    public $configured = false;

    public function configure(Server $server): void
    {
        $this->configured = true;
    }
}
