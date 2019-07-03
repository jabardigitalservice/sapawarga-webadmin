
<?php

class NewsJabarCest
{
    public function getNewsJabarStaffUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('staffrw');

        $I->sendGET('/v1/news-jabar');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 6);
    }
}
