<?php

declare(strict_types=1);

namespace K911\Swoole\Bridge\Symfony\Bundle\EventDispatcher;

use K911\Swoole\Bridge\Symfony\Event\WorkerStartedEvent;
use K911\Swoole\Server\WorkerHandler\WorkerStartHandlerInterface;
use OpenSwoole\Server;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class EventDispatchingWorkerStartHandler implements WorkerStartHandlerInterface
{
    public function __construct(private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function handle(Server $worker, int $workerId): void
    {
        $this->eventDispatcher->dispatch(new WorkerStartedEvent($worker, $workerId), WorkerStartedEvent::NAME);
    }
}
