<?php
namespace Products;

use \ApiTester;

class CreateCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function createValidProduct(ApiTester $I)
    {
        $product = ['Title' => 'Test Product', 'Price' => 1.0];

        $I->wantTo('create a Product via API');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('/api/v1/products/', $product);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($product);
    }
}
