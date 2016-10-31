<?php
namespace Carts;

use \ApiTester;

class RemoveProductCest
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
    public function removeProductFromCart(ApiTester $I)
    {
        $I->wantTo("Remove product from Cart #{$this->cartId} via API");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT("/api/v1/carts/{$this->cartId}/REMOVE", ['products' => [1]]);
        $I->seeResponseCodeIs(200);
        list($total_price) = $I->grabDataFromResponseByJsonPath('$.TotalPrice');
        $I->assertEquals(number_format(2.99 + 3.99, 2), $total_price);
    }
}
