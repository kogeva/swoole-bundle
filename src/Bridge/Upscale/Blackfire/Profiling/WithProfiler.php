<?php

declare(strict_types=1);

namespace K911\Swoole\Bridge\Upscale\Blackfire\Profiling;

use K911\Swoole\Server\Configurator\ConfiguratorInterface;
use OpenSwoole\Http\Server;

final class WithProfiler implements ConfiguratorInterface
{
    public function __construct(private ProfilerActivator $profilerActivator)
    {
    }

    public function configure(Server $server): void
    {
        $this->profilerActivator->activate($server);
    }
}
