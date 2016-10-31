<?php
namespace Products;

use \ApiTester;

class ListCest
{
    // tests
    public function listAll(ApiTester $I)
    {
        $I->wantTo('List all Products via API');
        $I->sendGET('/api/v1/products/');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $products = $I->grabDataFromResponseByJsonPath('$.*');
        $I->assertEquals(LIST_PAGE_SIZE, count($products));
    }

    // tests
    public function listAllPage2(ApiTester $I)
    {
        $I->wantTo('List all Products in page 2 via API');
        $I->sendGET('/api/v1/products/?page=2');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $products = $I->grabDataFromResponseByJsonPath('$.*');
        $I->assertLessOrEquals(LIST_PAGE_SIZE, count($products));
    }

    // tests
    public function listExisting(ApiTester $I)
    {
        $I->wantTo('List existing Product via API');
        $I->sendGET('/api/v1/products/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    // tests
    public function listNonExisting(ApiTester $I)
    {
        $id = NON_EXISTING_ID;
        $I->wantTo("List non-existing Product #{$id} via API");
        $I->sendGET("/api/v1/products/{$id}");
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
    }
}
