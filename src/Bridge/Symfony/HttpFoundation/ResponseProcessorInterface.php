<?php

declare(strict_types=1);

namespace K911\Swoole\Bridge\Symfony\HttpFoundation;

use OpenSwoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

interface ResponseProcessorInterface
{
    public function process(HttpFoundationResponse $httpFoundationResponse, SwooleResponse $swooleResponse): void;
}
