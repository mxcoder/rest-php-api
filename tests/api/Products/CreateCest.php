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
        $data = ['Title' => 'Test Product', 'Price' => 1.0];

        $I->wantTo('Create a Product via API');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('/api/v1/products/', $data);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($data);
    }

    // tests
    public function createInvalidProductNoTitle(ApiTester $I)
    {
        $data = ['Price' => 1.0];

        $I->wantTo('Create a Product via API with missing Title');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('/api/v1/products/', $data);
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['error' => 'Product title length must be at least 5 chars and maximum 255 chars']);
    }

    // tests
    public function createInvalidProductNoPrice(ApiTester $I)
    {
        $data = ['Title' => 'Test Product'];

        $I->wantTo('Create a Product via API with missing Price');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('/api/v1/products/', $data);
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['error' => 'Produce price must be a valid positive amount']);
    }
}
