<?php

declare(strict_types=1);

namespace K911\Swoole\Bridge\Symfony\HttpKernel;

use K911\Swoole\Bridge\Symfony\HttpFoundation\RequestFactoryInterface;
use K911\Swoole\Bridge\Symfony\HttpFoundation\ResponseProcessorInjectorInterface;
use K911\Swoole\Bridge\Symfony\HttpFoundation\ResponseProcessorInterface;
use K911\Swoole\Server\RequestHandler\RequestHandlerInterface;
use K911\Swoole\Server\Runtime\BootableInterface;
use OpenSwoole\Http\Request as SwooleRequest;
use OpenSwoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpKernel\TerminableInterface;

final class HttpKernelRequestHandler implements RequestHandlerInterface, BootableInterface
{
    public function __construct(
        private KernelPoolInterface $kernelPool,
        private RequestFactoryInterface $requestFactory,
        private ResponseProcessorInjectorInterface $processorInjector,
        private ResponseProcessorInterface $responseProcessor
    ) {
    }

    public function boot(array $runtimeConfiguration = []): void
    {
        $this->kernelPool->boot();
    }

    /**
     * @throws \Exception
     */
    public function handle(SwooleRequest $request, SwooleResponse $response): void
    {
        $httpFoundationRequest = $this->requestFactory->make($request);
        $this->processorInjector->injectProcessor($httpFoundationRequest, $response);
        $kernel = $this->kernelPool->get();
        $httpFoundationResponse = $kernel->handle($httpFoundationRequest);
        $this->responseProcessor->process($httpFoundationResponse, $response);

        if ($kernel instanceof TerminableInterface) {
            $kernel->terminate($httpFoundationRequest, $httpFoundationResponse);
        }

        $this->kernelPool->return($kernel);
    }
}
