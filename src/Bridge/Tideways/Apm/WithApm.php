<?php

declare(strict_types=1);

namespace K911\Swoole\Bridge\Tideways\Apm;

use K911\Swoole\Server\Configurator\ConfiguratorInterface;
use OpenSwoole\Http\Server;

final class WithApm implements ConfiguratorInterface
{
    public function __construct(private Apm $apm)
    {
    }

    public function configure(Server $server): void
    {
        $this->apm->instrument($server);
    }
}
