<?php

class CategoryCest
{
    private $endpointCategory = '/v1/categories';

    public function createNewCategoryNameExist(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointCategory, [
            'type'      => 'phonebook',
            'name'      => 'Kesehatan',
            'status'    => 10,
        ]);

        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function createNewCategory(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointCategory, [
            'type'      => 'phonebook',
            'name'      => 'New Phonebook Category',
            'status'    => 10,
        ]);

        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);
    }

    public function getCategoryListAll(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointCategory);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseContainsJson([
            'type' => 'phonebook',
        ]);

        $I->seeResponseContainsJson([
            'type' => 'broadcast',
        ]);
    }

    public function getCategoryListPhonebook(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointCategory}?type=phonebook");
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseContainsJson([
            'type' => 'phonebook',
        ]);

        $I->cantSeeResponseContainsJson([
            'type' => 'broadcast',
        ]);
    }

    public function getCategoryItemNotFound(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointCategory}/999");
        $I->canSeeResponseCodeIs(404);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 404,
        ]);
    }

    public function getCategoryItem(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointCategory}/1");
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success'   => true,
            'status'    => 200,
            'data'      => [
                'id' => 1,
                'type' => 'phonebook',
                'name' => 'Kesehatan',
                'status' => 10,
            ]
        ]);
    }

    public function updateCategory(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPUT("{$this->endpointCategory}/1", [
            'name' => 'Layanan Kesehatan Edited',
        ]);

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function deleteCategory(ApiTester $I)
    {
        $I->amStaff();

        $I->sendDELETE("{$this->endpointCategory}/1");
        $I->canSeeResponseCodeIs(204);
    }
}
