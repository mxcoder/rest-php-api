<?php
namespace GOG\Controllers;

use GOG\Models\Cart as CartModel;
use GOG\Models\Product as ProductModel;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
* Carts REST API
*/
class Carts extends Base
{
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
        $session = $request->getAttribute('session');
        $this->Cart = CartModel::findPK($session['cart_id']);
    }

    /**
     * GET action
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function getAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $response->write($this->Cart->toJSON());
    }

    /**
     * POST action
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function postAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $response->write($this->Cart->toJSON());
    }

    /**
     * PUT action
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function putAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        return $response->write($this->Cart->toJSON());
    }
}
