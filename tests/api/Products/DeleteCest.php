<?php
namespace Products;

use \ApiTester;

class DeleteCest
{
    // tests
    public function deleteExistingProduct(ApiTester $I)
    {
        $I->sendGET('/api/v1/products/?page=2');
        list($id) = $I->grabDataFromResponseByJsonPath('$[-1].Id');

        $I->wantTo("Delete a Product {$id} via API");
        $I->sendDelete("/api/v1/products/{$id}");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    // tests
    public function deleteNonExistingProduct(ApiTester $I)
    {
        $id = NON_EXISTING_ID;
        $I->wantTo("Delete a Product #{$id} via API");
        $I->sendDelete("/api/v1/products/{$id}");
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
    }
}
