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
    public function getAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $ProductQuery = ProductModel::createQuery();
        if (!empty($args['id'])) {
            $body = $ProductQuery->findPK($args['id'])->toJSON();
        } else {
            $page = $request->getQueryParam('page', 1);
            $body = $ProductQuery->paginate($page, API_LIST_PAGE_SIZE)->toJSON();
        }
        return $response->write($body);
    }

    /**
     * POST action - Create product
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function postAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $body = $request->getParsedBody();
        $Product = new ProductModel();
        $Product->fromArray($body);
        $Product->save();
        $this->logger->info("New product: {$Product}");
        return $response->write($Product->toJSON());
    }

    /**
     * PUT action - Update Product
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function putAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = isset($args['id']) ? intval($args['id']) : null;
        if (empty($id)) {
            throw new \Exception('PUT /products requires a valid numeric ID: /products/[0-9]+');
        }
        $body = $request->getParsedBody();
        $Product = ProductModel::findPK($id);
        $Product->fromArray($body);
        $Product->save();
        $this->logger->info("Updated product: {$Product}");
        return $response->write($Product->toJSON());
    }

    /**
     * DELETE action - Delete Product
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function deleteAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = isset($args['id']) ? intval($args['id']) : null;
        if (empty($id)) {
            throw new \Exception('DELETE /products requires a valid numeric ID: /products/[0-9]+');
        }
        $Product = ProductModel::findPK($id);
        $Product->delete();
        $this->logger->info("Deleted product: {$Product}");
        return $response->write($Product->toJSON());
    }
}
