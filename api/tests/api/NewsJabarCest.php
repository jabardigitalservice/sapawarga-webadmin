<?php

class NewsJabarCest
{
    public function getUserNewsJabarTest(ApiTester $I)
    {
        $I->amUser('staffrw');

        $I->sendGET('/v1/news-jabar');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $items = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(6, count($items[0]));
    }
}
