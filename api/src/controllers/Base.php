<?php
namespace GOG\Controllers;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
* Base REST API
*/
class Base
{
    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $httpMethod = strtolower($request->getMethod() ?: 'GET');
        $actionArg = isset($args['action']) ? ucfirst(strtolower($args['action'])) : 'Action';
        $classMethod = "{$httpMethod}{$actionArg}";
        return $this->$classMethod($request, $response, $args);
    }

    public static function propelMiddleWare(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');
        return $response;
    }
}
