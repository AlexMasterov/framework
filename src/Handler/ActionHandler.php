<?php

namespace Equip\Handler;

use Equip\Adr\InputInterface;
use Equip\Adr\PayloadInterface;
use Equip\Adr\ResponderInterface;
use Equip\Contract\ActionInterface;
use Equip\Resolver\ResolverTrait;
use Equip\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\ResolverInterface;

class ActionHandler
{
    use ResolverTrait;

    const ROUTE_ATTRIBUTE = 'equip/adr:route';

    /**
     * @param ResolverInterface $resolver
     */
    public function __construct(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
        $route = $request->getAttribute(self::ROUTE_ATTRIBUTE);
        $request = $request->withoutAttribute(self::ROUTE_ATTRIBUTE);

        $response = $this->handle($route, $request, $response);

        return $next($request, $response);
    }

    /**
     * Use the action collaborators to get a response.
     *
     * @param Route $route
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    private function handle(
        Route $route,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $action = $this->resolve($route->getAction());
        $input = $this->resolve($route->getInput());
        $responder = $this->resolve($route->getResponder());

        $payload = $this->payload($action, $input, $request);
        $response = $this->response($responder, $request, $response, $payload);

        return $response;
    }

    /**
     * Execute the action to get a payload using input from the request.
     *
     * @param ActionInterface $action
     * @param InputInterface $input
     * @param ServerRequestInterface $request
     *
     * @return PayloadInterface
     */
    private function payload(
        ActionInterface $action,
        InputInterface $input,
        ServerRequestInterface $request
    ) {
        return $action($input($request));
    }

    /**
     * Execute the responder to marshall the payload into the response.
     *
     * @param ResponderInterface $responder
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param PayloadInterface $payload
     *
     * @return ResponseInterface
     */
    private function response(
        ResponderInterface $responder,
        ServerRequestInterface $request,
        ResponseInterface $response,
        PayloadInterface $payload
    ) {
        return $responder($request, $response, $payload);
    }
}
