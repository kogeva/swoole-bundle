<?php

declare(strict_types=1);

namespace K911\Swoole\Tests\Unit\Component\AtomicCounter;

use OpenSwoole\Atomic;

final class AtomicStub extends Atomic
{
    public function __construct(private int $value)
    {
        parent::__construct(0);
    }

    public function get(): int
    {
        return $this->value;
    }
}
