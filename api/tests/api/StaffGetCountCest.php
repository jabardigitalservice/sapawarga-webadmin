<?php

class StaffGetCountCest
{
    private $endpoint = '/v1/staff/count';

    public function staffGetCount(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpoint);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data' => [
                'items' => [
                    [
                        'id' => 1,
                        'level' => 'all',
                    ],
                ],
            ],
        ]);
    }
}
