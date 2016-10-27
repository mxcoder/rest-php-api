<?php
namespace Products;

use \ApiTester;

class UpdateCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function updateExistingProductValidData(ApiTester $I)
    {
        $data = ['Price' => 1.0];

        $I->wantTo('Update Product #1 via API with new Price');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT('/api/v1/products/1', $data);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($data);
    }

    // tests
    public function updateExistingProductInvalidData(ApiTester $I)
    {
        $data = ['Price' => 0];

        $I->wantTo('Update Product #1 via API with invalid new Price');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT('/api/v1/products/1', $data);
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
    }

    // tests
    public function updateNonExistingProductValidData(ApiTester $I)
    {
        $id = NON_EXISTING_ID;
        $data = ['Price' => 1.0];

        $I->wantTo("Update non-existing Product #{$id} via API with new Price");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT("/api/v1/products/{$id}", $data);
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
    }

    // tests
    public function updateNonExistingProductInvalidData(ApiTester $I)
    {
        $id = NON_EXISTING_ID;
        $data = ['Price' => 0];

        $I->wantTo("Update non-existing Product #{$id} via API with invalid Price");
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPUT("/api/v1/products/{$id}", $data);
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
    }
}
