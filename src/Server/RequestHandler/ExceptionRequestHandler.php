<?php

declare(strict_types=1);

namespace K911\Swoole\Server\RequestHandler;

use K911\Swoole\Server\RequestHandler\ExceptionHandler\ExceptionHandlerInterface;
use OpenSwoole\Http\Request;
use OpenSwoole\Http\Response;

final class ExceptionRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private RequestHandlerInterface $decorated,
        private ExceptionHandlerInterface $exceptionHandler
    ) {
    }

    public function handle(Request $request, Response $response): void
    {
        try {
            $this->decorated->handle($request, $response);
        } catch (\Throwable $exception) {
            $this->exceptionHandler->handle($request, $exception, $response);
        }
    }
}
