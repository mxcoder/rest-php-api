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
     * GET action
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @param  array                  $args
     * @return ResponseInterface
     */
    public function getAction(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $ProductQuery = ProductModel::createQuery();
        if (!empty($args['id'])) {
            $body = $ProductQuery->findPK($args['id'])->toJSON();
        } else {
            $body = $ProductQuery->find()->toJSON();
        }
        return $response->write($body);
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
        $body = $request->getParsedBody();
        return $response->write(var_dump($body, true));
    }
}
