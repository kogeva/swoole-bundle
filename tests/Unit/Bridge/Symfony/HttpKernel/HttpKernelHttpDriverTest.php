<?php

declare(strict_types=1);

namespace K911\Swoole\Tests\Unit\Bridge\Symfony\HttpKernel;

use K911\Swoole\Bridge\Symfony\HttpFoundation\RequestFactoryInterface;
use K911\Swoole\Bridge\Symfony\HttpFoundation\ResponseProcessorInjectorInterface;
use K911\Swoole\Bridge\Symfony\HttpFoundation\ResponseProcessorInterface;
use K911\Swoole\Bridge\Symfony\HttpKernel\HttpKernelRequestHandler;
use K911\Swoole\Bridge\Symfony\HttpKernel\KernelPoolInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use OpenSwoole\Http\Request as SwooleRequest;
use OpenSwoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

class HttpKernelHttpDriverTest extends TestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;
    /**
     * @var HttpKernelRequestHandler
     */
    private $httpDriver;

    /**
     * @var ObjectProphecy|ResponseProcessorInterface
     */
    private $responseProcessor;

    /**
     * @var ObjectProphecy|RequestFactoryInterface
     */
    private $requestFactoryProphecy;

    /**
     * @var ObjectProphecy|ResponseProcessorInjectorInterface
     */
    private $responseProcessorInjectorProphecy;

    /**
     * @var KernelPoolInterface|ObjectProphecy
     */
    private $kernelPoolProphecy;

    /**
     * @var KernelInterface|ObjectProphecy|TerminableInterface
     */
    private $kernelProphecy;

    protected function setUp(): void
    {
        $this->kernelProphecy = $this->prophesize(KernelInterface::class);
        $this->kernelPoolProphecy = $this->prophesize(KernelPoolInterface::class);
        $this->requestFactoryProphecy = $this->prophesize(RequestFactoryInterface::class);
        $this->responseProcessorInjectorProphecy = $this->prophesize(ResponseProcessorInjectorInterface::class);
        $this->responseProcessor = $this->prophesize(ResponseProcessorInterface::class);

        /** @var KernelPoolInterface $kernelPoolMock */
        $kernelPoolMock = $this->kernelPoolProphecy->reveal();
        /** @var RequestFactoryInterface $requestFactoryMock */
        $requestFactoryMock = $this->requestFactoryProphecy->reveal();
        /** @var ResponseProcessorInjectorInterface $responseProcessorInjectorMock */
        $responseProcessorInjectorMock = $this->responseProcessorInjectorProphecy->reveal();
        /** @var ResponseProcessorInterface $responseProcessorMock */
        $responseProcessorMock = $this->responseProcessor->reveal();

        $this->httpDriver = new HttpKernelRequestHandler(
            $kernelPoolMock,
            $requestFactoryMock,
            $responseProcessorInjectorMock,
            $responseProcessorMock
        );
    }

    public function testBoot(): void
    {
        $this->kernelPoolProphecy->boot()->shouldBeCalled();

        $this->httpDriver->boot();
    }

    /**
     * @throws \Exception
     */
    public function testHandleNonTerminable(): void
    {
        $swooleRequest = new SwooleRequest();
        $swooleResponse = new SwooleResponse();

        $httpFoundationResponse = new HttpFoundationResponse();
        $httpFoundationRequest = new HttpFoundationRequest();

        $this->requestFactoryProphecy->make($swooleRequest)->willReturn($httpFoundationRequest)->shouldBeCalled();
        $this->kernelPoolProphecy->get()->willReturn($this->kernelProphecy)->shouldBeCalled();
        $this->kernelPoolProphecy->return($this->kernelProphecy)->shouldBeCalled();
        $this->kernelProphecy->handle($httpFoundationRequest)->willReturn($httpFoundationResponse)->shouldBeCalled();
        $this->responseProcessorInjectorProphecy->injectProcessor($httpFoundationRequest, $swooleResponse)
            ->shouldBeCalled()
        ;
        $this->responseProcessor->process($httpFoundationResponse, $swooleResponse)->shouldBeCalled();

        $this->httpDriver->handle($swooleRequest, $swooleResponse);
    }

    /**
     * @throws \Exception
     */
    public function testHandleTerminable(): void
    {
        $this->setUpTerminableKernel();

        $swooleRequest = new SwooleRequest();
        $swooleResponse = new SwooleResponse();

        $httpFoundationResponse = new HttpFoundationResponse();
        $httpFoundationRequest = new HttpFoundationRequest();

        $this->requestFactoryProphecy->make($swooleRequest)->willReturn($httpFoundationRequest)->shouldBeCalled();
        $this->kernelPoolProphecy->get()->willReturn($this->kernelProphecy)->shouldBeCalled();
        $this->kernelPoolProphecy->return($this->kernelProphecy)->shouldBeCalled();
        $this->kernelProphecy->handle($httpFoundationRequest)->willReturn($httpFoundationResponse)->shouldBeCalled();
        $this->responseProcessorInjectorProphecy->injectProcessor($httpFoundationRequest, $swooleResponse)
            ->shouldBeCalled()
        ;
        $this->responseProcessor->process($httpFoundationResponse, $swooleResponse)->shouldBeCalled();
        $this->kernelProphecy->terminate($httpFoundationRequest, $httpFoundationResponse)->shouldBeCalled();

        $this->httpDriver->handle($swooleRequest, $swooleResponse);
    }

    private function setUpTerminableKernel(): void
    {
        $this->kernelProphecy = $this->prophesize(KernelInterface::class)->willImplement(TerminableInterface::class);

        /** @var KernelPoolInterface $kernelPoolMock */
        $kernelPoolMock = $this->kernelPoolProphecy->reveal();
        /** @var RequestFactoryInterface $requestFactoryMock */
        $requestFactoryMock = $this->requestFactoryProphecy->reveal();
        /** @var ResponseProcessorInjectorInterface $responseProcessorInjectorMock */
        $responseProcessorInjectorMock = $this->responseProcessorInjectorProphecy->reveal();
        /** @var ResponseProcessorInterface $responseProcessorMock */
        $responseProcessorMock = $this->responseProcessor->reveal();

        $this->httpDriver = new HttpKernelRequestHandler(
            $kernelPoolMock,
            $requestFactoryMock,
            $responseProcessorInjectorMock,
            $responseProcessorMock
        );
    }
}
