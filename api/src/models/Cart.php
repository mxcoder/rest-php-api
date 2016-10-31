<?php
namespace GOG\Models;

use GOG\Models\Base\Cart as BaseCart;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Map\TableMap;

class Cart extends BaseCart
{
    public function __toString()
    {
        return "Cart #{$this->getId()}. Products Qty: {$this->getQtyProducts(true)}. Total: {$this->getTotalPrice(true)}";
    }

    public function getQtyProducts($formatted = false)
    {
        $value = $this->getProducts()->count();
        return $formatted ? number_format($value) : $value;
    }

    public function getTotalPrice($formatted = false)
    {
        $value = array_sum($this->getProducts()->getColumnValues('Price'));
        return $formatted ? money_format('%.2n', $value) : $value;
    }

    public function getProductsArray($formatted = false)
    {
        $Products = [];
        foreach ($this->getProducts() as $Product) {
            $Products[] = $formatted ? "{$Product}" : $Product->toArray(TableMap::TYPE_PHPNAME, false, [], false);
        }
        return $Products;
    }

    public function toSimpleArray($formatted = false)
    {
        $this->setVirtualColumn('QtyProducts', $this->getQtyProducts($formatted));
        $this->setVirtualColumn('TotalPrice', $this->getTotalPrice($formatted));
        $this->setVirtualColumn('Products', $this->getProductsArray($formatted));
        return $this->toArray(TableMap::TYPE_PHPNAME, false, [], false);
    }

    public function preSave(ConnectionInterface $con = null)
    {
        if ($this->getProducts()->count() > 3) {
            throw new \Exception('Cart cannot hold more than 3 products');
        }
        return parent::preSave($con);
    }
}
