<?php
namespace GOG\Models;

use GOG\Models\Base\Cart as BaseCart;

class Cart extends BaseCart
{
    public static function read($pk)
    {
        return self::createQuery()
            ->useProductCartQuery()
                ->joinWithProduct()
            ->endUse()
            ->filterByPrimaryKey($pk)
            ->find();
    }

    public function __toString()
    {
        return "Cart #{$this->getId()}. Products Qty: {$this->getProducts()->count()}";
    }
}
