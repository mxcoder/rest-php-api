<?php
namespace GOG\Models;

use GOG\Models\Base\Product as BaseProduct;
use Propel\Runtime\Connection\ConnectionInterface;

class Product extends BaseProduct
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
        return "{$this->getTitle()} (#{$this->getId()}) - {$this->getPrice(true)}";
    }

    public function getPrice($formatted = false)
    {
        $value = parent::getPrice();
        return $formatted ? money_format('%.2n', $value) : $value;
    }

    public function preSave(ConnectionInterface $con = null)
    {
        if (strlen($this->getTitle()) < 5 || strlen($this->getTitle()) > 255) {
            throw new \Exception('Product name length must be at least 5 chars and maximum 255 chars');
        }
        if ($this->getPrice() <= 0) {
            throw new \Exception('Produce price must be a valid positive amount');
        }

        return parent::preSave($con);
    }
}
