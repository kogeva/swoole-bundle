<?php

declare(strict_types=1);

namespace K911\Swoole\Tests\Unit\Component\AtomicCounter;

use OpenSwoole\Atomic;

final class AtomicSpy extends Atomic
{
    public $incremented = false;

    public function __construct()
    {
        parent::__construct(0);
    }

    public function add($value = null): int
    {
        $this->incremented = 1 === $value;

        return $this->incremented ? 1 : 0;
    }
}
