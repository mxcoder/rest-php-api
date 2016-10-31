<?php
namespace GOG\Models;

use GOG\Models\Base\CartQuery as BaseCartQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class CartQuery extends BaseCartQuery
{
    /**
     * Joins Carts with Products through n-n table
     * while adding virtual columns for rollup values
     * @return Criteria
     */
    public function withProducts()
    {
        return $this
            ->leftJoinProductCart()
            ->leftJoinWith('ProductCart.Product');
    }
}
