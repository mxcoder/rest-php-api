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
    /**
     * GET action - Reads Cart
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    /**
     * @ApiDescription(section="Carts", description="List one or many carts in session")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/carts/{id}")
     * @ApiParams(name="id", type="integer", nullable=true, description="Product id", sample="1")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{'Id':'int', 'Title':'string', 'Price':'number'}")
     */
    final public function getAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = isset($args['id']) ? intval($args['id']) : null;
        // Find only Carts that belong to the current session
        $CartQuery = CartModel::createQuery()->filterById($this->session('carts'));
        if (!empty($id)) {
            $Cart = $CartQuery->withProducts()->findPk($id) or $this->throwException("Cart {$id} cannot be found.");
            $Result = $Cart->toSimpleArray();
        } else {
            $Result = $CartQuery->find()->toArray();
        }
        return $response->withJson($Result);
    }

    /**
     * POST action - Creates a new cart
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    /**
     * @ApiDescription(section="Carts", description="Creates a cart")
     * @ApiMethod(type="post")
     * @ApiRoute(name="/carts")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{'Id':'number', 'QtyProducts':'number','TotalPrice':'number','Products':[]}")
     * @ApiReturnHeaders(sample="HTTP 500 Internal Server Error")
     * @ApiReturn(type="object", sample="{'error':'string'}")
     */
    final public function postAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $my_carts = $this->session('carts');
        $Cart = new CartModel();
        $Cart->save();
        $my_carts[] = $Cart->getId();
        $this->session('carts', $my_carts);

        $this->logger->info("Created {$Cart}");
        return $response->withJson($Cart->toSimpleArray());
    }

    /**
     * PUT action - Puts product(s) in Cart
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    /**
     * @ApiDescription(section="Carts", description="Adds or removes a product from Cart")
     * @ApiMethod(type="put")
     * @ApiRoute(name="/carts/{id}/{action}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Product id", sample="1")
     * @ApiParams(name="action", type="string", nullable=false, description="Cart operation: ADD or REMOVE", sample="ADD")
     * @ApiParams(name="products", type="array", description="Product ID or IDs", sample="1")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{'Id':'number', 'QtyProducts':'number','TotalPrice':'number','Products':[{'Id':'number','Title':'string','Price':'number'}]}")
     * @ApiReturnHeaders(sample="HTTP 500 Internal Server Error")
     * @ApiReturn(type="object", sample="{'error':'string'}")
     */
    final public function putAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $my_carts = $this->session('carts');
        // Get the Cart to which we're adding the products
        $id = isset($args['id']) ? intval($args['id']) : null;
        if (empty($id)) {
            $this->throwException('PUT /carts/{id}/{action} requires a valid numeric ID: /carts/[0-9]+');
        }
        if (!in_array($id, $my_carts)) {
            $this->throwException('PUT /carts/{id}/{action} only works with carts in session');
        }
        // Read the action to performa: ADD or REMOVE
        $action = isset($args['action']) ? strtoupper(trim($args['action'])) : null;
        if (!in_array($action, ['ADD', 'REMOVE'])) {
            $this->throwException('PUT /carts/{id}/{action} requires an action: ADD or REMOVE');
        }
        $Cart = CartModel::createQuery()->withProducts()->findPk($id) or $this->throwException("Cart {$id} cannot be found.");
        // Read the payload, either single or array of product IDs
        $body = $request->getParsedBody();
        if (empty($body['products'])) {
            $this->throwException('PUT /carts/{id}/{action} requires an array payload with key "products"');
        }
        // To ease handling single or bulk add, we always use bulk approach
        if (!is_array($body['products'])) {
            $body['products'] = [$body['products']];
        }
        $Products = ProductModel::createQuery()->filterById($body['products'])->find();
        foreach ($Products as $Product) {
            if ($action === 'ADD') {
                $Cart->addProduct($Product);
            } elseif ($action === 'REMOVE') {
                $Cart->removeProduct($Product);
            }
        }
        $Cart->save();

        $this->logger->info("Updated {$Cart}");
        return $response->withJson($Cart->toSimpleArray());
    }

    /**
     * DELETE action - Puts product(s) in Cart
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    /**
     * @ApiDescription(section="Carts", description="Deletes a cart")
     * @ApiMethod(type="delete")
     * @ApiRoute(name="/carts/{id}")
     * @ApiParams(name="id", type="number", nullable="false", description="Cart ID", sample="1")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturnHeaders(sample="HTTP 500 Internal Server Error")
     * @ApiReturn(type="object", sample="{'error':'string'}")
     */
    final public function deleteAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $my_carts = $this->session('carts');
        // Get the Cart to which we're adding the products
        $id = isset($args['id']) ? intval($args['id']) : null;
        if (empty($id)) {
            $this->throwException('DELETE /carts/{id}/ requires a valid numeric ID: /carts/[0-9]+');
        }
        if (!in_array($id, $my_carts)) {
            $this->throwException('DELETE /carts/{id}/ only works with carts in session');
        }
        // Remove the cart from the database
        $Cart = CartModel::findPk($id) or $this->throwException("Cart {$id} cannot be found.");
        $Cart->delete();
        // Update session to remove the cart id
        $my_carts = $this->session('carts');
        $key = array_search($id, $my_carts);
        if ($key !== null || $key !== false) {
            unset($my_carts[$key]);
        }
        $this->session('carts', $my_carts);

        $this->logger->info("Deleted {$Cart}");
        return $response;
    }
}
