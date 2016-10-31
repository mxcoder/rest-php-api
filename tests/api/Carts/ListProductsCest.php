<?php
namespace Carts;

use \ApiTester;

class ListProductsCest
{
    protected $cartId;

    public function _before(ApiTester $I)
    {
        $I->sendPOST('/api/v1/carts/');
        list($cart) = $I->grabDataFromResponseByJsonPath('$');
        $this->cartId = $cart['Id'];
        $I->sendPUT("/api/v1/carts/{$this->cartId}/ADD", ['products' => [1, 2, 3]]);
    }

    // tests
    public function validateProductsInCart(ApiTester $I)
    {
        $I->sendGET("/api/v1/carts/{$this->cartId}");
        $products_ids = $I->grabDataFromResponseByJsonPath('$.Products.*.Id');
        $I->seeResponseCodeIs(200);
        $I->assertEquals([1, 2, 3], $products_ids);
    }
}
