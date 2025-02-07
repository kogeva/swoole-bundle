<?php

declare(strict_types=1);

namespace K911\Swoole\Bridge\Symfony\HttpFoundation;

use OpenSwoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

final class ResponseProcessorInjector implements ResponseProcessorInjectorInterface
{
    public function __construct(private ResponseProcessorInterface $responseProcessor)
    {
    }

    public function injectProcessor(
        HttpFoundationRequest $request,
        SwooleResponse $swooleResponse
    ): void {
        $request->attributes->set(
            self::ATTR_KEY_RESPONSE_PROCESSOR,
            function (HttpFoundationResponse $httpFoundationResponse) use ($swooleResponse): void {
                $this->responseProcessor->process($httpFoundationResponse, $swooleResponse);
            }
        );
    }
}
