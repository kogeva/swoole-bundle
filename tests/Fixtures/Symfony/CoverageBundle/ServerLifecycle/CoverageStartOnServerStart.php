<?php

declare(strict_types=1);

namespace K911\Swoole\Tests\Fixtures\Symfony\CoverageBundle\ServerLifecycle;

use K911\Swoole\Server\LifecycleHandler\ServerStartHandlerInterface;
use K911\Swoole\Tests\Fixtures\Symfony\CoverageBundle\Coverage\CodeCoverageManager;
use OpenSwoole\Server;

final class CoverageStartOnServerStart implements ServerStartHandlerInterface
{
    public function __construct(
        private CodeCoverageManager $codeCoverageManager,
        private ?ServerStartHandlerInterface $decorated = null
    ) {
    }

    public function handle(Server $server): void
    {
        $this->codeCoverageManager->start('test_server');

        if ($this->decorated instanceof ServerStartHandlerInterface) {
            $this->decorated->handle($server);
        }
    }
}
