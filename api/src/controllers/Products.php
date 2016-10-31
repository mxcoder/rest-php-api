<?php
namespace GOG\Controllers;

use GOG\Models\Product as ProductModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
* Products REST API
*/
class Products extends Base
{
    /**
     * GET action - List all products / Describe one product
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args      [id => integer], if present describes single product
     * @return ResponseInterface
     */
    /**
     * @ApiDescription(section="Products", description="List one or many products")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/products/{id}")
     * @ApiParams(name="id", type="integer", nullable=true, description="Product id", sample="1")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturnHeaders(sample="LastPage: {integer}")
     * @ApiReturn(type="object ", description="List by pages of 3 products", sample="[{'Id':'integer', 'Title':'string', 'Price':'float'}, ...]")
     * @ApiReturn(type="object", description="Single product", sample="{'Id':'integer', 'Title':'string', 'Price':'float'}")
     */
    final public function getAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = isset($args['id']) ? intval($args['id']) : null;
        $ProductQuery = ProductModel::createQuery();
        if (!empty($id)) {
            $Result = $ProductQuery->findPK($args['id']) or $this->throwException("Product {$id} cannot be found.");
        } else {
            $page = $request->getQueryParam('page', 1);
            $Result = $ProductQuery->paginate($page, LIST_PAGE_SIZE);
            $response = $response->withHeader('LastPage', $Result->getLastPage());
        }
        return $response->withJson($Result->toArray());
    }

    /**
     * POST action - Create product
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    /**
     * @ApiDescription(section="Products", description="Creates a product")
     * @ApiMethod(type="post")
     * @ApiRoute(name="/products")
     * @ApiParams(name="Title", type="string", description="Product title", sample="Some new product")
     * @ApiParams(name="Price", type="number", description="Product price", sample="9.99")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{'Title':'string','Price':'number'}")
     * @ApiReturnHeaders(sample="HTTP 500 Internal Server Error")
     * @ApiReturn(type="object", sample="{'error':'string'}")
     */
    final public function postAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $body = $request->getParsedBody();
        if (isset($body['Id'])) {
            unset($body['Id']);
        }
        $Product = new ProductModel();
        $Product->fromArray($body);
        $Product->save();
        $this->logger->info("New product: {$Product}");
        return $response->withJson($Product->toArray());
    }

    /**
     * PUT action - Update Product
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    /**
     * @ApiDescription(section="Products", description="Updates a product")
     * @ApiMethod(type="put")
     * @ApiRoute(name="/products/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="Product id", sample="1")
     * @ApiParams(name="Title", type="string", description="Product title", sample="Some new product")
     * @ApiParams(name="Price", type="number", description="Product price", sample="9.99")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturn(type="object", sample="{'Id':'number',Title':'string','Price':'number'}")
     * @ApiReturnHeaders(sample="HTTP 500 Internal Server Error")
     * @ApiReturn(type="object", sample="{'error':'string'}")
     */
    final public function putAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = isset($args['id']) ? intval($args['id']) : null;
        if (empty($id)) {
            throw new \Exception('PUT /products requires a valid numeric ID: /products/[0-9]+');
        }
        $body = $request->getParsedBody();
        $Product = ProductModel::findPK($id) or $this->throwException("Product {$id} cannot be found.");
        $Product->fromArray($body);
        $Product->save();
        $this->logger->info("Updated product: {$Product}");
        return $response->withJson($Product->toArray());
    }

    /**
     * DELETE action - Delete Product
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    /**
     * @ApiDescription(section="Products", description="Deletes a product")
     * @ApiMethod(type="delete")
     * @ApiRoute(name="/products/{id}")
     * @ApiParams(name="id", type="number", nullable="false", description="Product ID", sample="1")
     * @ApiReturnHeaders(sample="HTTP 200 OK")
     * @ApiReturnHeaders(sample="HTTP 500 Internal Server Error")
     * @ApiReturn(type="object", sample="{'error':'string'}")
     */
    final public function deleteAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = isset($args['id']) ? intval($args['id']) : null;
        if (empty($id)) {
            throw new \Exception('DELETE /products requires a valid numeric ID: /products/[0-9]+');
        }
        $Product = ProductModel::findPK($id) or $this->throwException("Product {$id} cannot be found.");
        $Product->delete();
        $this->logger->info("Deleted product: {$Product}");
        return $response;
    }
}
