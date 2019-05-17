<?php

class AspirasiApprovalCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function postApprovalStaffTest(ApiTester $I)
    {
        $I->amStaff();

        $data = [
            'action' => 'APPROVE',
            'notes'  => 'Test',
        ];

        $I->sendPOST('/v1/aspirasi-approval/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postApprovalUserTest(ApiTester $I)
    {
        $I->amUser();

        $data = [
            'action' => 'APPROVE',
            'notes'  => 'Test',
        ];

        $I->sendPOST('/v1/aspirasi-approval/1', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postApprovalInvalidStatusTest(ApiTester $I)
    {
        // @TODO jika aspirasi tersebut sudah pernah diapprove
    }
}
