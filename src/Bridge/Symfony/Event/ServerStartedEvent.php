<?php

declare(strict_types=1);

namespace K911\Swoole\Bridge\Symfony\Event;

use OpenSwoole\Server;
use Symfony\Contracts\EventDispatcher\Event;

final class ServerStartedEvent extends Event
{
    public const NAME = 'swoole_bundle.server.started';

    public function __construct(private Server $server)
    {
    }

    public function getServer(): Server
    {
        return $this->server;
    }
}
