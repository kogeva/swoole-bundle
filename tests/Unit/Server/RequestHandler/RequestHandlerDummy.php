<?php

declare(strict_types=1);

namespace K911\Swoole\Tests\Unit\Server\RequestHandler;

use K911\Swoole\Server\RequestHandler\RequestHandlerInterface;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;

final class RequestHandlerDummy implements RequestHandlerInterface
{
    public function handle(Request $request, Response $response): void
    {
    }
}
