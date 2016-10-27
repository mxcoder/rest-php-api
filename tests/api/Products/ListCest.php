<?php
namespace Products;

use \ApiTester;

class ListCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function listAll(ApiTester $I)
    {
        $I->wantTo('list Products via API');
        $I->sendGET('/api/v1/products/');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $products = $I->grabDataFromResponseByJsonPath('$.*');
        $I->assertEquals(LIST_PAGE_SIZE, count($products));
    }
}
