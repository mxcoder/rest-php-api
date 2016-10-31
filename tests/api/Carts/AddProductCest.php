<?php
namespace Carts;

use \ApiTester;

class AddProductCest
{
    protected $cartId;

    public function _before(ApiTester $I)
    {
        $I->sendPOST('/api/v1/carts/');
        list($cart) = $I->grabDataFromResponseByJsonPath('$');
        $this->cartId = $cart['Id'];
    }

    // tests
    public function addSingleProductCart(ApiTester $I)
    {
        $I->wantTo("Add a single product to Cart #{$this->cartId} via API");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT("/api/v1/carts/{$this->cartId}/ADD", ['products' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    // tests
    public function addTwoProductsCart(ApiTester $I)
    {
        $I->wantTo("Add two products to Cart #{$this->cartId} via API");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT("/api/v1/carts/{$this->cartId}/ADD", ['products' => [2, 3]]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    // tests
    public function validateProductsMaxOnCart(ApiTester $I)
    {
        $I->wantTo("Validate max products on Cart #{$this->cartId} via API");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT("/api/v1/carts/{$this->cartId}/ADD", ['products' => [1, 2, 3, 4]]);
        $I->seeResponseCodeIs(500);
    }

    // tests
    public function validateProductTotalOnCart(ApiTester $I)
    {
        $I->wantTo("Validate products total price on Cart #{$this->cartId} via API");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT("/api/v1/carts/{$this->cartId}/ADD", ['products' => [1, 2, 3]]);
        $I->seeResponseCodeIs(200);
        list($total_price) = $I->grabDataFromResponseByJsonPath('$.TotalPrice');
        $I->assertEquals(number_format(1.99 + 2.99 + 3.99, 2), $total_price);
    }
}
