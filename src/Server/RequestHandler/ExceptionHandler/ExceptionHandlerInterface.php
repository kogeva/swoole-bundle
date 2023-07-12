<?php

declare(strict_types=1);

namespace K911\Swoole\Server\RequestHandler\ExceptionHandler;

use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;

interface ExceptionHandlerInterface
{
    public function handle(Request $request, \Throwable $exception, Response $response): void;
}
