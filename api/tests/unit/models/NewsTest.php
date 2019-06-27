<?php

namespace tests\unit\models;

use app\models\News;
use Codeception\Test\Unit;

class NewsTest extends Unit
{
    public function testTitleRequired()
    {
        $model = new News();

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));

        $model->title = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));

        $model->title = 'Ini adalah judul';

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testTitleMinCharactersShouldFail()
    {
        $model = new News();

        // allow min 10 chars
        $model->title = '123';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleMinCharactersSuccess()
    {
        $model = new News();

        // allow min 10 chars
        $model->title = '1234567890';

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testTitleMaxCharactersShouldFail()
    {
        $model = new News();

        // max 100 chars
        // 101 chars should fail
        $model->title = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean ma';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleMaxCharactersSuccess()
    {
        $model = new News();

        // max 100 chars
        // 100 chars should success
        $model->title = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean m';

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testTitleNotSafe()
    {
        $model = new News();

        $model->title = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testChannelRequired()
    {
        $model = new News();

        $model->validate();

        $this->assertTrue($model->hasErrors('channel_id'));

        $model->channel_id = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('channel_id'));

        $model->channel_id = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('channel_id'));
    }

    public function testChannelMustInteger()
    {
        $model = new News();

        $model->channel_id = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('channel_id'));

        $model->channel_id = 'xxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('channel_id'));
    }

    public function testUrlRequired()
    {
        $model = new News();

        $model->validate();

        $this->assertTrue($model->hasErrors('external_url'));

        $model->external_url = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('external_url'));

        $model->external_url = 'http://google.com';

        $model->validate();

        $this->assertFalse($model->hasErrors('external_url'));
    }

    public function testUrlScheme()
    {
        $model = new News();

        $model->external_url = 'test';

        $model->validate();

        $this->assertTrue($model->hasErrors('external_url'));

        $model->external_url = 'test.com';

        $model->validate();

        $this->assertTrue($model->hasErrors('external_url'));

        $model->external_url = 'http://google.com';

        $model->validate();

        $this->assertFalse($model->hasErrors('external_url'));
    }

    public function testSourceDateRequired()
    {
        $model = new News();

        $model->validate();

        $this->assertTrue($model->hasErrors('source_date'));

        $model->source_date = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('source_date'));

        $model->source_date = '2019-06-01';

        $model->validate();

        $this->assertFalse($model->hasErrors('source_date'));
    }

    public function testSourceDateValidValue()
    {
        $model = new News();

        $model->source_date = '2019-06-01';

        $model->validate();

        $this->assertFalse($model->hasErrors('source_date'));
    }

    public function testSourceDateInvalidStringValue()
    {
        $model = new News();

        $model->source_date = 'xxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('source_date'));
    }

    public function testSourceDateInvalidIntegerValue()
    {
        $model = new News();

        $model->source_date = 100;

        $model->validate();

        $this->assertTrue($model->hasErrors('source_date'));
    }

    public function testSourceDateInvalidBooleanValue()
    {
        $model = new News();

        $model->source_date = true;

        $model->validate();

        $this->assertTrue($model->hasErrors('source_date'));
    }

    public function testFeaturedRequired()
    {
        $model = new News();

        $model->validate();

        $this->assertTrue($model->hasErrors('featured'));

        $model->featured = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('featured'));

        $model->featured = false;

        $model->validate();

        $this->assertFalse($model->hasErrors('featured'));
    }

    public function testFeaturedValidBooleanValue()
    {
        $model = new News();

        $model->featured = true;

        $model->validate();

        $this->assertFalse($model->hasErrors('featured'));

        $model->featured = 'true';

        $model->validate();

        $this->assertTrue($model->hasErrors('featured'));

        $model->featured = 'xxxxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('featured'));

        $model->featured = 2;

        $model->validate();

        $this->assertTrue($model->hasErrors('featured'));
    }

    public function testContentRequired()
    {
        $model = new News();

        $model->validate();

        $this->assertTrue($model->hasErrors('content'));

        $model->content = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('content'));

        $model->content = 'Test ini adalah content berita';

        $model->validate();

        $this->assertFalse($model->hasErrors('content'));
    }

    public function testContentMaxCharactersShouldFail()
    {
        $model = new News();

        $model->content = file_get_contents(__DIR__ . '/../../data/5572chars_html.txt');

        $model->validate();

        $this->assertTrue($model->hasErrors('content'));
    }

    public function testContentMaxCharactersSuccess()
    {
        $model = new News();

        $model->content = file_get_contents(__DIR__ . '/../../data/5000chars_html.txt');

        $model->validate();

        $this->assertFalse($model->hasErrors('content'));
    }

    public function testStatusRequired()
    {
        $model = new News();

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));

        $model->status = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));

        $model->status = 10;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }

    public function testStatusInputString()
    {
        $model = new News();

        $model->status = 'OK';

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }

    public function testStatusInputInteger()
    {
        $model = new News();

        $model->status = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }

    public function testStatusInputAllowedInteger()
    {
        $model = new News();

        // Status = DELETED
        $model->status = -1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));

        // Status = DISABLED
        $model->status = 0;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));

        // Status = ACTIVE
        $model->status = 10;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));

        // Status, Random
        $model->status = 2;

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));

        // Status, Random
        $model->status = 5;

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }
}
