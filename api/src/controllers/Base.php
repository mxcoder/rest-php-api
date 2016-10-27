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
    protected $logger;

    /**
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $this->logger = $ci->logger;
    }

    /**
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $httpMethod = strtolower($request->getMethod() ?: 'GET');
        $actionArg = isset($args['action']) ? ucfirst(strtolower($args['action'])) : 'Action';
        $classMethod = "{$httpMethod}{$actionArg}";
        try {
            $response = $this->$classMethod($request, $response, $args);
        } catch (\Exception $e) {
            $response->write(json_encode(['error' => $e->getMessage()]));
        }
        return $response;
    }

    /**
     * Home route
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public static function home(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $response->write("Hello");
        return $response;
    }

    /**
     * Propel Middleware
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  callable               $next
     * @return ResponseInterface
     */
    public static function propelMiddleWare(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');
        return $response;
    }
}
