<?php

declare(strict_types=1);

namespace K911\Swoole\Server\Middleware;

use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;

interface Middleware
{
    public function __invoke(Request $request, Response $response): void;
}
