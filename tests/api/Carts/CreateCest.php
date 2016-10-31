<?php
namespace Carts;

use \ApiTester;

class CreateCest
{
    // tests
    public function createCart(ApiTester $I)
    {
        $I->wantTo('Create a Cart via API');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('/api/v1/carts/');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
