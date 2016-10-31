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
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $httpMethod = strtolower($request->getMethod() ?: 'GET');
        $actionArg = 'Action';
        $classMethod = "{$httpMethod}{$actionArg}";
        try {
            $response = $this->$classMethod($request, $response, $args);
        } catch (\Exception $e) {
            $response = $response->withJson(['error' => $e->getMessage()])->withStatus(500);
        }
        return $response;
    }

    /**
     * Helper method to throw from Controllers
     * @param  string          $message
     * @param  \Exception|null $previous
     * @throws \Exception
     * @return null
     */
    protected function throwException($message, \Exception $previous = null)
    {
        throw new \Exception($message, 1, $previous);
    }

    /**
     * Helper method to handle session data
     * @param  string  $key
     * @param  mixed   $value false to read, null to unset, else sets
     * @return mixed
     */
    protected function session($key, $value = false)
    {
        if ($value === false) {
            $this->logger->debug("Reading SESSION[{$key}]:" . var_export($_SESSION[$key], true));
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        } elseif ($value === null) {
            $this->logger->debug("Deleting SESSION[{$key}]");
            if (isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
            }
            return true;
        } else {
            $this->logger->debug("Setting SESSION[{$key}]: " . var_export($value, true));
            $_SESSION[$key] = $value;
        }
    }
}
